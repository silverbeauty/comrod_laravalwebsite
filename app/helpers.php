<?php

use App\Ad;
use App\City;
use App\User;
use App\Niche;
use App\Reason;
use App\Region;
use App\Comment;
use App\Content;
use App\Country;
use App\Language;
use App\LiveFeed;
use Carbon\Carbon;
use App\CameraModel;
use App\VehicleMake;
use App\VehicleType;
use Aws\S3\S3Client;
use App\CommentReply;
use App\VehicleColor;
use App\VehicleModel;
use App\ReportedContent;
use App\Services\ErrorLog;
use App\SuggestedLocation;
use Cocur\Slugify\Slugify;
use Jenssegers\Agent\Agent;
use App\ContentLicensePlate;
use Illuminate\Http\Request;
use App\ContentInactiveEmbed;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Cmgmyr\Messenger\Models\Thread;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

function s3Client()
{
    return S3Client::factory([
        'version' => '2006-03-01',
        'credentials' => [
            'key' => config('filesystems.disks.s3.key'),
            'secret' => config('filesystems.disks.s3.secret'),
        ],
        'region' => config('filesystems.disks.s3.region'),            
    ]);
}

function s3Sync($client, $source, $destination)
{
    if ($destination) {
        $client->uploadDirectory($source, config('filesystems.disks.s3.bucket'), $destination);
    }
}

function ISO8601ToSeconds($ISO8601)
{
    preg_match('/\d{1,2}[H]/', $ISO8601, $hours);
    preg_match('/\d{1,2}[M]/', $ISO8601, $minutes);
    preg_match('/\d{1,2}[S]/', $ISO8601, $seconds);
    
    $duration = [
        'hours'   => $hours ? $hours[0] : 0,
        'minutes' => $minutes ? $minutes[0] : 0,
        'seconds' => $seconds ? $seconds[0] : 0,
    ];

    $hours   = substr($duration['hours'], 0, -1);
    $minutes = substr($duration['minutes'], 0, -1);
    $seconds = substr($duration['seconds'], 0, -1);

    $toltalSeconds = ($hours * 60 * 60) + ($minutes * 60) + $seconds;

    return $toltalSeconds;
}

function asset_cdn($path, $elixir = false)
{
    if ($elixir) {
        return config('app.asset_base_url') . trim(elixir($path), '/');
    }

    return config('app.asset_base_url') . $path;
}

function resize_remote_image($url, $height)
{
    try {
        $image = Image::make($url);
        
        $image->resize(null, $height, function ($constraint) {
            $constraint->aspectRatio();
        });

        return $image->response();
    } catch(\Exception $e) {

    }
}

function remote_file_exists($sftp, $path)
{
    // try {
    //     ssh2_sftp_stat($sftp, $path);
    //     return true;
    // } catch (\Exception $e) {
    //     return false;
    // }
    if ($path && Storage::disk('s3')->exists($path)) {
        return true;
    }

    return false;
}

function sftp()
{
    return false;

    try {
        $connection = ssh2_connect(config('app.storage_server_ip'));
        ssh2_auth_password($connection, 'root', config('app.storage_server_password'));
        $sftp = ssh2_sftp($connection);

        return $sftp;

    } catch (\Exception $e) {
        return false;
    }
}

function is_rtl()
{
    return in_array(subdomain(), ['il', 'ar']);
}
function carbon_set_locale()
{
    Carbon::setlocale(subdomain());
}

function linkify($value, $protocols = array('http', 'mail'), array $attributes = array('target' => '_blank'))
{
    // Link attributes
    $attr = '';
    foreach ($attributes as $key => $val) {
        $attr = ' ' . $key . '="' . htmlentities($val) . '"';
    }
    
    $links = array();
    
    // Extract existing links and tags
    $value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { return '<' . array_push($links, $match[1]) . '>'; }, $value);
    
    // Extract text links for each protocol
    foreach ((array)$protocols as $protocol) {
        switch ($protocol) {
            case 'http':
            case 'https':   $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { if ($match[1]) $protocol = $match[1]; $link = $match[2] ?: $match[3]; return '<' . array_push($links, "<a $attr href=\"$protocol://$link\">$link</a>") . '>'; }, $value); break;
            case 'mail':    $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
            case 'twitter': $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1]  . "\">{$match[0]}</a>") . '>'; }, $value); break;
            default:        $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
        }
    }
    
    // Insert all link
    return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) { return $links[$match[1] - 1]; }, $value);
}

function decrypt_data($data)
{
    $key128 = "uLqw0iB4WPcZyUNV";
    $iv = "VNUyZcPW4Bi0wqLu";   
    $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128,'','cbc',$iv);

    mcrypt_generic_init($cipher, $key128, $iv);
    $decrypted = mdecrypt_generic($cipher,base64_decode($data));
    mcrypt_generic_deinit($cipher);
    
    return $decrypted;    
}

function encrypt_data($data)
{
    $key128 = "uLqw0iB4WPcZyUNV";
    $iv = "VNUyZcPW4Bi0wqLu";
    $cipher = mcrypt_module_open(MCRYPT_RIJNDAEL_128,'','cbc',$iv);
    mcrypt_generic_init($cipher, $key128, $iv);

    $encrypted = base64_encode(mcrypt_generic($cipher,$data));
    mcrypt_generic_deinit($cipher);
    
    return $encrypted;    
}

function strip_tags_content($text, $tags = '<br>', $invert = FALSE)
{ 
    preg_match_all('/<(.+?)[\s]*\/?[\s]*>/si', trim($tags), $tags); 
    $tags = array_unique($tags[1]); 

    if(is_array($tags) AND count($tags) > 0) { 
        if($invert == FALSE) { 
            return preg_replace('@<(?!(?:'. implode('|', $tags) .')\b)(\w+)\b.*?>.*?</\1>@si', '', $text); 
        } else { 
            return preg_replace('@<('. implode('|', $tags) .')\b.*?>.*?</\1>@si', '', $text); 
        } 
    } elseif($invert == FALSE) { 
        return preg_replace('@<(\w+)\b.*?>.*?</\1>@si', '', $text); 
    }

    return $text;
}

function facebook_url($country_code)
{
    $country_code = strtolower($country_code);
    $global = 'http://www.facebook.com/comroads';
    $urls['il'] = 'https://www.facebook.com/comroads.il';
    $urls['gb'] = 'https://www.facebook.com/comroads.uk';
    $urls['au'] = 'http://www.facebook.com/comroads.au';
    $urls['nz'] = 'http://www.facebook.com/comroads.nz';

    return isset($urls[$country_code]) ? $urls[$country_code] : $global;
}

function languages()
{
    $languages = Cache::get('languages');

    if (is_null($languages)) {
        Cache::put('languages', Language::all(), env('CACHE_TIME', 43200));
        $languages = Cache::get('languages');
    }

    return $languages;
}

function slugify($value)
{
    $slugify = new Slugify;

    $slugify->addRuleset('hebrew', [

        'א' => 'א',

        'ב' => 'ב',

        'ג' => 'ג'
    ]);

    $slugify->activateRuleset('hebrew');

    return $slugify->slugify($value);
}

function total_messages(User $user)
{
    return count(Thread::forUserWithNewMessages($user->id)->latest('updated_at')->get());
}

function ad($id)
{
    $ad = Cache::get('ad_'.$id);
    if (is_null($ad)) {
        $ad = Ad::find($id);
        if (is_null($ad)) {
            Cache::put('ad_'.$id, 'null', env('CACHE_TIME', 10));
        } else {
            Cache::put('ad_'.$id, $ad, env('CACHE_TIME', 10));
        }
    }
    return ($ad == 'null')?null:$ad;
}

function licenses($plates)
{
    $licenses = [];

    if (count($plates)) {
        foreach ($plates as $key => $plate) {
            if (!is_null($plate->info)) {
                $licenses[$key]['name'] = $plate->info->name;
                $licenses[$key]['country_code'] = $plate->info->country_code;
                $licenses[$key]['region_code'] = $plate->info->region_code;
                $licenses[$key]['type_id'] = $plate->info->type_id;
                $licenses[$key]['make_id'] = $plate->info->make_id;
                $licenses[$key]['model_id'] = $plate->info->model_id;
                $licenses[$key]['color_id'] = $plate->info->color_id;
            }
        }
    }

    return $licenses;
}

function translation_groups()
{
    return Translation::select(['group'])->groupBy('group')->get();
}

function extract_date($date, $key)
{
    $date = DateTime::createFromFormat('Y-m-d H:i:s', $date);

    return $date->format($key);
}

function in_array_r($needle, $haystack, $strict = false) {
    foreach ($haystack as $item) {
        if (($strict ? $item === $needle : $item == $needle) || (is_array($item) && in_array_r($needle, $item, $strict))) {
            return true;
        }
    }

    return false;
}

function total_unencoded_contents()
{

    return number_format(Content::whereNull('encoded_date')->whereType('video')->whereNull('embed_type')->count());
}

function total_live_feeds()
{

    return number_format(LiveFeed::all()->count());
}

function total_deleted_feeds()
{

    return number_format(LiveFeed::withTrashed()->all()->count());
}

function upload_content_default_data()
{
    $data['countries'] = countries();
    $data['camera_models'] = camera_models();
    $data['vehicle_types'] = vehicle_types();
    $data['vehicle_makes'] = vehicle_makes();
    $data['vehicle_colors'] = vehicle_colors();
    $data['licenses'] = old('licenses') ?: [[
        'name' => null,
        'country_code' => null,
        'region_code' => null,
        'type_id' => null,
        'make_id' => null,
        'model_id' => null,
        'color_id' => null
    ]];

    return $data;
}

function total_reported_contents()
{
    return number_format(ReportedContent::count());
}

function total_deleted_contents()
{
    return number_format(Content::onlyTrashed()->count());
}

function total_pending_contents()
{
    return number_format(Content::whereApproved(0)->count());
}

function total_published_contents()
{
    return number_format(Content::whereApproved(1)->count());
}

function total_private_contents()
{
    return number_format(Content::wherePrivate(1)->whereApproved(1)->count());
}

function total_app_contents()
{
    return number_format(Content::whereSource('mobile')->whereApproved(1)->count());
}

function total_comments()
{
    return number_format(Comment::count() + CommentReply::count());
}

function total_users()
{
    return number_format(User::count());
}

function total_suggested_locations()
{
    return number_format(SuggestedLocation::has('content')->count());
}

function total_multiple_violations()
{
    $plates_id = ContentLicensePlate::select(DB::raw('*, count(*) as plate_count'))
                    ->groupBy('license_id')
                    ->having('plate_count', '>', 1)                    
                    ->get()
                    ->pluck('license_id');

    return number_format(ContentLicensePlate::with('content.owner', 'info')
                    ->select(DB::raw('*, count(*) as content_count'))
                    ->whereIn('license_id', $plates_id)
                    ->groupBy('content_id')
                    ->having('content_count', '=', 1)
                    ->has('info')
                    ->has('content')                    
                    ->get()->count());
}

function total_inactive_embed()
{
    return number_format(ContentInactiveEmbed::count());
}

function manage_comment_menu($comment)
{
    $menu = '
        <div class="btn-group">
            <button
                type="button"
                class="btn btn-default dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >Action <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right">';
            if ($comment->url) {
                $menu .= '<li><a href="'.$comment->url.'" target="_blank">View</a></li>';
            } else {
                $menu .= '<li><a>Content has been removed</a></li>';
            }
            $menu .= '<li>
                    <a
                        data-toggle="modal"
                        data-target="#editCommentModal"
                        data-backdrop="static"
                        data-content="'.htmlentities(json_encode(["id" => $comment->id, "body" => $comment->body, "type" => $comment->type])).'"
                    >Edit</a>
                </li>';
    $menu .= '<li role="separator" class="divider"></li>';
    $menu .= '<li>
                <a
                    class="confirm-action"
                    data-confirm-title="Are you sure?"
                    data-confirm-body="You will not able to recover this comment once it will be deleted permanently"
                    data-confirm-button-text="Yes, delete permanently!"
                    data-ajax-data="'.htmlentities(json_encode(["id" => $comment->id, "type" => $comment->type])).'"
                    data-url="'.route('admin::postForceDeleteComment').'"
                    data-reload="true"
                >Delete Permanently</a>
            </li>';
    $menu .= '</ul>
        </div>';

    return $menu;
}

function manage_content_menu(Content $content)
{
    $menu = '
        <div class="btn-group">
            <button
                type="button"
                class="btn btn-default dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >Action <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right">
                <li><a href="'.$content->url.'" target="_blank">View</a></li>
                <li><a href="'.route('admin::getContentSettings', [$content->id]).'">Settings</a></li>';

    if ($content->is_pending) {
        $menu .= '<li>
                    <a
                        class="confirm-action"
                        data-confirm-title="Are you sure?"
                        data-confirm-body="You are about to publish this content"
                        data-confirm-button-text="Yes, publish it!"
                        data-ajax-data=\'{"id": '.$content->id.'}\'
                        data-url="'.route('admin::postPublishContent').'"
                        data-reload="true"
                    >Publish</a>
                </li>';
    }

    if ($content->is_published) {
        $menu .= '<li>
                    <a
                        class="confirm-action"
                        data-confirm-title="Are you sure?"
                        data-confirm-body="You are about to set this content to pending"
                        data-confirm-button-text="Yes, set as pending!"
                        data-ajax-data=\'{"id": '.$content->id.'}\'
                        data-url="'.route('admin::postSetContentAsPending').'"
                        data-reload="true"
                    >Set as Pending</a>
                </li>';
    }

    if ($content->type == 'video' && is_null($content->embed_type)) {
        $menu .= '<li>
                    <a class="btn-ajax" data-url="'.route('admin::postEncodeContent').'" data-ajax-data='.json_encode(['id' => $content->id]).' data-loading-text="'.button_loading('Encoding...').'" data-reload="true">Encode</a>
                </li>';
    }

    if ($content->trashed()) {
        $menu .= '
        <li>
            <a
                class="confirm-action"
                data-confirm-title="Are you sure?"
                data-confirm-body="You are about to restore this content"
                data-confirm-button-text="Yes, restore it!"
                data-ajax-data=\'{"id": '.$content->id.'}\'
                data-url="'.route('admin::postRestoreContent').'"
                data-reload="true"
            >Restore</a>
        </li>';
    }

    $menu .= '<li role="separator" class="divider"></li>';

    if ($content->trashed()) {
        $menu .= '
        <li>
            <a
                class="confirm-action"
                data-confirm-title="Are you sure?"
                data-confirm-body="You will not able to recover this content once it will be deleted permanently"
                data-confirm-button-text="Yes, delete permanently!"
                data-ajax-data=\'{"id": '.$content->id.'}\'
                data-url="'.route('admin::postForceDeleteContent').'"
                data-reload="true"
            >Delete Permanently</a>
        </li>';
    }

    if (!$content->trashed()) {
        $menu .= '<li>
                    <a
                        class="confirm-action"
                        data-confirm-title="Are you sure?"
                        data-confirm-body="You are about to delete this content"
                        data-confirm-button-text="Yes, delete it!"
                        data-ajax-data=\'{"id": '.$content->id.'}\'
                        data-url="'.route('admin::postDeleteContent').'"
                        data-reload="true"
                    >Delete</a>
                </li>';
    }
                
    $menu .= '</ul>
        </div>';

    return $menu;
}

function manage_live_feed_menu(LiveFeed $feed)
{
    $menu = '
        <div class="btn-group">
            <button
                type="button"
                class="btn btn-default dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >Action <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right">
                <li><a href="'.$feed->url.'" target="_blank">View</a></li>
                <li><a href="'.route('admin::getEditLiveFeed', [$feed->id]).'">Settings</a></li>';
                if (! $feed->trashed()) {
                    $menu .= '<li>
                                <a
                                    class="confirm-action"
                                    data-confirm-title="Are you sure?"
                                    data-confirm-body="You are about to delete this content"
                                    data-confirm-button-text="Yes, delete it!"
                                    data-ajax-data=\'{"id": '.$feed->id.'}\'
                                    data-url="'.route('admin::postDeleteLiveFeed').'"
                                    data-reload="true"
                                >Delete</a>
                            </li>';
                }
                
    $menu .= '</ul>
        </div>';

    return $menu;
}

function manage_reported_content_menu(Content $content, ReportedContent $report)
{
    $menu = '
        <div class="btn-group">
            <button
                type="button"
                class="btn btn-default dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >Action <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right">
                <li><a href="'.$content->url.'" target="_blank">View</a></li>
                <li><a href="'.route('admin::getContentSettings', [$content->id]).'">Settings</a></li>';

    if ($content->is_pending) {
        $menu .= '<li>
                    <a
                        class="confirm-action"
                        data-confirm-title="Are you sure?"
                        data-confirm-body="You are about to publish this content"
                        data-confirm-button-text="Yes, publish it!"
                        data-ajax-data=\'{"id": '.$content->id.'}\'
                        data-url="'.route('admin::postPublishContent').'"
                        data-reload="true"
                    >Publish</a>
                </li>';
    }

    if ($content->is_published) {
        $menu .= '<li>
                    <a
                        class="confirm-action"
                        data-confirm-title="Are you sure?"
                        data-confirm-body="You are about to set this content to pending"
                        data-confirm-button-text="Yes, set as pending!"
                        data-ajax-data=\'{"id": '.$content->id.'}\'
                        data-url="'.route('admin::postSetContentAsPending').'"
                        data-reload="true"
                    >Set as Pending</a>
                </li>';
    }

    if ($content->type == 'video' && is_null($content->embed_type)) {
        $menu .= '<li>
                    <a class="btn-ajax" data-url="'.route('admin::postEncodeContent').'" data-ajax-data='.json_encode(['id' => $content->id]).' data-loading-text="'.button_loading('Encoding...').'" data-reload="true">Encode</a>
                </li>';
    }

    if ($content->trashed()) {
        $menu .= '
        <li>
            <a
                class="confirm-action"
                data-confirm-title="Are you sure?"
                data-confirm-body="You are about to restore this content"
                data-confirm-button-text="Yes, restore it!"
                data-ajax-data=\'{"id": '.$content->id.'}\'
                data-url="'.route('admin::postRestoreContent').'"
                data-reload="true"
            >Restore '.ucfirst($content->type).'</a>
        </li>';
    }

    $menu .= '<li role="separator" class="divider"></li>';

    if ($content->trashed()) {
        $menu .= '
        <li>
            <a
                class="confirm-action"
                data-confirm-title="Are you sure?"
                data-confirm-body="You will not able to recover this content once it will be deleted permanently"
                data-confirm-button-text="Yes, delete permanently!"
                data-ajax-data=\'{"id": '.$content->id.'}\'
                data-url="'.route('admin::postForceDeleteContent').'"
                data-reload="true"
            >Delete '.ucfirst($content->type).' Permanently</a>
        </li>';
    }

    if (!$content->trashed()) {
        $menu .= '<li>
                    <a
                        class="confirm-action"
                        data-confirm-title="Are you sure?"
                        data-confirm-body="You are about to delete this content"
                        data-confirm-button-text="Yes, delete it!"
                        data-ajax-data=\'{"id": '.$content->id.'}\'
                        data-url="'.route('admin::postDeleteContent').'"
                        data-reload="true"
                    >Delete '.ucfirst($content->type).'</a>
                </li>';
    }

    $menu .= '<li>
        <a
            class="confirm-action"
            data-confirm-title="Are you sure?"
            data-confirm-body="You are about to delete this report"
            data-confirm-button-text="Yes, delete it!"
            data-ajax-data=\'{"id": '.$report->id.'}\'
            data-url="'.route('admin::postDeleteContentReport').'"
            data-reload="true"
        >Delete Report</a>
    </li>';
                
    $menu .= '</ul>
        </div>';

    return $menu;
}

function manage_user_menu(User $user)
{
    $menu = '
        <div class="btn-group">
            <button
                type="button"
                class="btn btn-default dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >Action <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right">
                <li><a href="'.$user->url.'" target="_blank">View</a></li>
                <li><a href="'.route('admin::getImpersonate', [$user->id]).'">Login</a></li>
                <li><a href="'.route('admin::getUserSettings', [$user->id]).'">Settings</a></li>                
                <li role="separator" class="divider"></li>';
    if ($user->trashed()) {
        $menu .= '<li>
                    <a
                        class="confirm-action"
                        data-confirm-title="Are you sure?"
                        data-confirm-body="You are about to restore this user"
                        data-confirm-button-text="Yes, restore it!"
                        data-ajax-data=\'{"id": '.$user->id.'}\'
                        data-url="'.route('admin::postRestoreUser').'"
                        data-reload="true"
                    >Restore</a>
                </li>';
    } else {
        $menu .= '<li>
                    <a
                        class="confirm-action"
                        data-confirm-title="Are you sure?"
                        data-confirm-body="You are about to delete this user"
                        data-confirm-button-text="Yes, delete it!"
                        data-ajax-data=\'{"id": '.$user->id.'}\'
                        data-url="'.route('admin::postDeleteUser').'"
                        data-reload="true"
                    >Delete</a>
                </li>';
    }
                
    $menu .= '</ul>
        </div>';

    return $menu;
}

function manage_translator_menu(User $user)
{
    $menu = '
        <div class="btn-group">
            <button
                type="button"
                class="btn btn-default dropdown-toggle"
                data-toggle="dropdown"
                aria-haspopup="true"
                aria-expanded="false"
            >Action <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right">
                <li><a href="'.$user->url.'" target="_blank">View</a></li>
                <li><a href="'.route('admin::getImpersonate', [$user->id]).'">Login</a></li>
                <li><a href="'.route('admin::getUserSettings', [$user->id]).'">Settings</a></li>
                <li>
                    <a
                        data-toggle="modal"
                        data-target="#addTranslatorFiltersModal"
                        data-backdrop="static"
                        data-content="'.htmlentities(json_encode([
                            'id' => $user->id,
                            "checkboxes" => [
                                'id_prefix' => 'exclude-country',
                                'key' => 'country_code',
                                'data' => $user->translatorExcludedCountries
                            ]
                        ])).'"
                    >Filters</a>
                </li>
                <li>
                    <a
                        data-toggle="modal"
                        data-target="#assignLanguageModal"
                        data-backdrop="static"
                        data-content="'.htmlentities(json_encode([
                            "id" => $user->id,
                            "checkboxes" => [
                                'id_prefix' => 'assign-language',
                                'key' => 'id',
                                'data' => $user->languages
                            ]
                        ])).'"
                    >Assign Language</a>
                </li>               
                <li role="separator" class="divider"></li>';

        $menu .= '<li>
                    <a
                        class="confirm-action"
                        data-confirm-title="Are you sure?"
                        data-confirm-body="You are about to remove this user as a translator"
                        data-confirm-button-text="Yes, remove it!"
                        data-ajax-data=\'{"id": '.$user->id.'}\'
                        data-url="'.route('admin::postDeleteTranslator').'"
                        data-reload="true"
                    >Delete</a>
                </li>';    
                
    $menu .= '</ul>
        </div>';

    return $menu;
}

function time_from_last_visit($last_login, $last_last_login)
{
    $timeFromLastVisit = null;    

    if ($last_login && $last_last_login) {
        $now = Carbon::now();
        $date2 = $last_last_login;
        $date1 = $last_login;

        $months1 = $now->diffInMonths($date1);
        $months2 = $now->diffInMonths($date2);

        $months = $months2 - $months1;
        $monthLabel = $months > 1 ? 'months1 ' : 'month ';
        $months = $months ? $months.' '.$monthLabel : '';

        $days1 = round((($now->diffInDays($date1) / 31) - $now->diffInMonths($date1)) * 10);
        $days2 = round((($now->diffInDays($date2) / 31) - $now->diffInMonths($date2)) * 10);

        //$days1 = $now->diffInDays($date1);
        //$days2 = $now->diffInDays($date2);

        $days = $days2 - $days1;
        $dayLabel = $days > 1 ? 'days ' : 'day ';
        $days = $days > 0 ? $days.' '.$dayLabel : '';

        $hours1 = round((($now->diffInHours($date1) / 24) - $now->diffInDays($date1)) * 10);
        $hours2 = round((($now->diffInHours($date2) / 24) - $now->diffInDays($date2)) * 10);

        //$hours1 = $now->diffInHours($date1);
        //$hours2 = $now->diffInHours($date2);

        $hours = $hours2 - $hours1;
        $hourLabel = $hours > 1 ? 'hours ' : 'hour ';
        $hours = $hours > 0 ? $hours.' '.$hourLabel : '';

        if (!$months && !$days && !$hours) {
            $hours = 'Less than an hour';
        }

        $timeFromLastVisit = $months . $days . $hours;
    }    

    return $timeFromLastVisit;
}

function time_from_last_last_visit($last_last_login)
{
    $lastLastLogin = null;

    if ($last_last_login) {
        $dt = Carbon::now();
        $months = $dt->diffInMonths($last_last_login);
        $monthLabel = $months > 1 ? 'months ' : 'month ';
        $monthsWithLabel = $months ? $months.' '.$monthLabel : '';

        $days = round((($dt->diffInDays($last_last_login) / 31) - $dt->diffInMonths($last_last_login)) * 10);
        $dayLabel = $days > 1 ? 'days ' : 'day ';
        $daysWithLabel = $days ? $days.' '.$dayLabel : '';

        $hours = round((($dt->diffInHours($last_last_login) / 24) - $dt->diffInDays($last_last_login)) * 10);
        $hourLabel = $hours > 1 ? 'hours ' : 'hour ';
        $hoursWithLabel = $hours ? $hours.' '.$hourLabel : '';

        if (!$months && !$days && !$hours) {
            $hoursWithLabel = 'Less than an hour';
        }

        $lastLastLogin = $monthsWithLabel . $daysWithLabel . $hoursWithLabel;
    }

    return $lastLastLogin;
}

function default_map_icon()
{
    return asset_cdn('images/categories/icon_8.png');
}

function map_zoom_by_country_code($code)
{
    $zoom['AU'] = 4;
    $zoom['US'] = 8;

    return isset($zoom[$code]) ? $zoom[$code] : 7;
}

function sorting($key)
{
    $data['highest_rated'] = 'total_rating';
    $data['most_discussed'] = 'total_comments';
    $data['most_viewed'] = 'total_views';
    $data['most_recent_uploaded'] = 'created_at';
    $data['most_recent_filmed'] = 'offence_date';

    return $data[$key];
}

function created_at_filter($key)
{
    $now = Carbon::now();
    $data['all_time'] = null;
    $data['hour_48'] = ['value' => $now->subDays(2)->toDateTimeString(), 'operator' => '>='];
    $data['week_2'] = ['value' => $now->subWeeks(2)->toDateTimeString(), 'operator' => '>='];
    $data['month_1'] = ['value' => $now->subMonth()->toDateTimeString(), 'operator' => '>='];
    $data['month_6'] = ['value' => $now->subMonths(6)->toDateTimeString(), 'operator' => '>='];
    $data['year_1'] = ['value' => $now->subYear()->toDateTimeString(), 'operator' => '>='];

    return $data[$key];
}

function filter_menu(array $query = [], $type = 1)
{
    //array_forget($query, ['sort_by', 'filter_by']);

    $highest_rated_key = 'highest_rated';
    $most_discussed_key = 'most_discussed';
    $most_viewed_key = 'most_viewed';
    $most_recent_uploaded_key = 'most_recent_uploaded';
    $most_recent_filmed_key = 'most_recent_filmed';
    $hour_48_key = 'hour_48';
    $week_2_key = 'week_2';
    $month_1_key = 'month_1';
    $month_6_key = 'month_6';
    $year_1_key = 'year_1';
    $all_time_key = 'all_time';

    $menu[1] = [
        'sorting' => [
            $highest_rated_key => ['alt_key' => 'total_likes', 'label' => trans('filter.rating'), 'url' => route('home', array_merge($query, ['sort_by' => $highest_rated_key]))],
            $most_discussed_key => ['alt_key' => 'total_comments', 'label' => trans('filter.comment-count'), 'url' => route('home', array_merge($query, ['sort_by' => $most_discussed_key]))],
            $most_viewed_key => ['alt_key' => 'total_original_views', 'label' => trans('filter.view-count'), 'url' => route('home', array_merge($query, ['sort_by' => $most_viewed_key]))],
            $most_recent_uploaded_key => ['alt_key' => 'upload_date', 'label' => trans('filter.upload-date'), 'url' => route('home', array_merge($query, ['sort_by' => $most_recent_uploaded_key]))],
            $most_recent_filmed_key => ['alt_key' => 'offence_date', 'label' => trans('filter.creation-date'), 'url' => route('home', array_merge($query, ['sort_by' => $most_recent_filmed_key]))]
        ],
        'filters' => [
            $hour_48_key => ['label' => trans('filter.48-hours'), 'alt_label' => trans('filter.past-48-hours'), 'url' => route('home', array_merge($query, ['filter_by' => $hour_48_key]))],
            $week_2_key => ['label' => trans('filter.2-weeks'), 'alt_label' => trans('filter.past-2-weeks'), 'url' => route('home', array_merge($query, ['filter_by' => $week_2_key]))],
            $month_1_key => ['label' => trans('filter.1-month'), 'alt_label' => trans('filter.past-month'), 'url' => route('home', array_merge($query, ['filter_by' => $month_1_key]))],            
            $month_6_key => ['label' => trans('filter.6-months'), 'alt_label' => trans('filter.past-6-months'), 'url' => route('home', array_merge($query, ['filter_by' => $month_6_key]))],
            $year_1_key => ['label' => trans('filter.1-year'), 'alt_label' => trans('filter.past-year'), 'url' => route('home', array_merge($query, ['filter_by' => $year_1_key]))],
            $all_time_key => ['label' => trans('filter.all-time'), 'alt_label' => trans('filter.all-time'), 'url' => route('home', array_merge($query, ['filter_by' => $all_time_key]))]
        ]
    ];

    return $menu[$type];
}

function user_geo($ip = null)
{
    return $ip ? geoip_record_by_name($ip) : geoip_record_by_name(user_ip());
}

function user_ip()
{
    $request = Request::capture();

    return config('app.env') == 'local' ? config('app.test_ip') : $request->ip();
}

function base_url($subdomain = null)
{
    if ($subdomain) {
        return config('app.protocol') . '://' . $subdomain . '.' . config('app.domain') . '/';
    }

    return config('app.protocol') . '://' . config('app.domain') . '/';
}

function map_info(Collection $content, $subdomain = null)
{
    $info = [];
    $contents = $content;
    
    foreach ($contents as $key => $content) {
        //if (($content->type == 'video' && $content->encoded_date !== null) || $content->type == 'photo') {
            $info[$key]['id'] = (int)$content->id;
            $info[$key]['lat'] = (double)$content->latitude;
            $info[$key]['lng'] = (double)$content->longitude;
            //$info[$key]['add'] = (string)$content->address;
            $info[$key]['cat'] = $content->categories->pluck('niche_id');
            //$info[$key]['images'] = $content->images;
            //$info[$key]['category_icon_url'] = (string)$content->first_category_icon_url;
            //$info[$key]['category_hover_icon_url'] = (string)$content->first_category_hover_icon_url;
            $info[$key]['icon'] = $content->first_category_icon;        
            $info[$key]['title'] = (string)$content->title;
            //$info[$key]['description'] = (string)$content->description;    
            //$info[$key]['url'] = (string)$content->url;
            $info[$key]['sd'] = $subdomain;
            $info[$key]['time'] = $content->start_in_seconds;

            if (!is_null($subdomain) && $subdomain != 'en') {
                //$time = $content->start_in_seconds ? '?t=' . $content->start_in_seconds : null;
                //$info[$key]['url'] = 'http://' . $subdomain . '.' . config('app.domain') . '/' . $content->type . '/' . slugify($content->getOriginal('title')).'-'.$content->id . $time;
            }

            $info[$key]['cc'] = (string)$content->country_code;
            $info[$key]['tu'] = (string)$content->thumbnail_url;
            //$info[$key]['total_views'] = (string)$content->formatted_total_views;
            //$info[$key]['total_comments'] = (int)$content->total_comments;
            //$info[$key]['total_rating'] = $content->total_rating;
            //$info[$key]['total_likes'] = (int)$content->total_likes; 
            //$info[$key]['total_dislikes'] = (int)$content->total_dislikes;
            //$info[$key]['upload_date'] = $content->getOriginal('created_at');
            //$info[$key]['offence_date'] = $content->offence_date;
            $info[$key]['hr'] = (int)$content->total_rating;
            $info[$key]['md'] = (int)$content->total_comments;
            $info[$key]['mv'] = (int)$content->getOriginal('total_views');
            $info[$key]['mru'] = $content->getOriginal('created_at');
            $info[$key]['mrf'] = $content->getOriginal('offence_date');
            $info[$key]['type'] = $content->type;
            $info[$key]['dur'] = $content->duration;
        //}       
    }

    return $info;
}

function delete_dir($dirPath)
{
    if (! is_dir($dirPath)) {
        return;
    }

    if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
        $dirPath .= '/';
    }

    $files = glob($dirPath . '*', GLOB_MARK);
    foreach ($files as $file) {
        if (is_dir($file)) {
            delete_dir($file);
        } else {
            unlink($file);
        }
    }
    
    rmdir($dirPath);
}

function remove_extension($filename)
{
    return preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
}

function youtube_id($url)
{
    $rx = '~
            ^(?:https?://)?              # Optional protocol
             (?:www\.)?                  # Optional subdomain
             (?:youtube\.com|youtu\.be)  # Mandatory domain name
             /(watch\?v=|embed/)?([^&]+)  # URI with video id as capture group 1
             ~x';

    preg_match($rx, $url, $matches);

    return isset($matches[2]) ? $matches[2] : null;
}

function vidme_id($url)
{
    $rx = '~
            ^(?:https?://)?              # Optional protocol
             (?:www\.)?                  # Optional subdomain
             (?:vid\.me)                 # Mandatory domain name
             /([^&]+)         # URI with video id as capture group 1
             ~x';

    preg_match($rx, $url, $matches);

    return isset($matches[1]) ? $matches[1] : null;
}

function vidme_info($url)
{
    $id = vidme_id($url);

    if (is_null($id)) {
        return;
    }

    $info = json_decode(@file_get_contents('https://api.vid.me/videoByUrl/'.$id), true);

    return $info;
}

function zencoder_watermark_url()
{
    return asset('images/watermark.png');
}

function default_avatar($size = 'small')
{
    return route('imagecache', ['template' => $size, 'filename' => 'default-user-avatar.png']);
}

function image_url($filename, $size = 'large')
{
    return route('imagecache', ['template' => $size, 'filename' => str_replace('.', '', $filename)]);    
}

function years($offset = 18)
{
    return range(date('Y') - $offset, 1940);
}

function countries()
{
    if (is_null($countries = Cache::get('countries'))) {
        $countries = Country::all();
        Cache::put('countries', $countries, env('CACHE_TIME', 10));
    }
    return $countries;
}

function need_region($country_code)
{
    return in_array($country_code, config('app.countries_need_state'));
}

function cities_by_country($country_code)
{
    return City::whereCountryCode($country_code)->get();
}

function regions_by_country($country_code)
{   
    if (is_null($video_region = Cache::get($country_code.'_region'))) {
        $video_region = Region::whereCountryCode($country_code)->get();
        Cache::put($country_code.'_region', $video_region, env('CACHE_TIME', 10));
    }
    
    return $video_region;
}

function countries_with_videos()
{
    if (is_null($countries = Cache::get('countries_with_videos'))) {
        $countries = Country::where('total_content', '!=', 0)->orderBy('total_content', 'desc')->get();
        Cache::put('countries_with_videos', $countries, env('CACHE_TIME', 10));
    }
    return $countries;
}

function categories_with_videos($type, $key)
{
    if (is_null($niche = Cache::get($key))) {
        $niche = Niche::whereEnabled(1)->whereType($type)->where('total_content', '!=', 0)->orderBy('total_content', 'desc')->get();
        Cache::put($key, $niche, env('CACHE_TIME', 10));
    }
    return $niche;
}

function reasons($type)
{
    if (is_null($video_reasons = Cache::get('video_reasons'))) {
        $video_reasons = Reason::whereType($type)->get();
        Cache::put('video_reasons', $video_reasons, env('CACHE_TIME', 10));
    }
    return $video_reasons;
}

function flash($title = null, $message = null)
{
    $flash = app(App\Http\Flash::class);

    if (func_num_args() == 0) {
        return $flash;
    }

    return $flash->message($title, $message);
}

function button_loading($text = null)
{
    $text = $text ? ' '.$text : '';
    return "<i class='fa fa-spinner fa-pulse'></i>".$text;
}

function flag_icon($country_code)
{
    return !is_null($country_code) ? '<i class="flag-icon flag-icon-'.strtolower($country_code).'"></i>' : '';
}

function make_dir($path)
{
    if (!file_exists($path)) {
        $oldumask = umask(0);
        mkdir($path, 0777, true);
        umask($oldumask);        
    }
}

function sub_dir($filename)
{
    $dir = null;

    for ($i=0; $i < 5; $i++) { 
        $dir .= substr($filename, $i, 1) . '/';
    }

    return $dir;
}

function sanitize_path($path)
{
    return str_replace('//', '/', $path);
}

function user_agent()
{
    $agent = new Agent;
    $userAgent = 'WEB';

    if ($agent->isiOS()) $userAgent = 'IOS';
    if ($agent->isAndroidOS()) $userAgent = 'ANDROID';

    return $userAgent;
}

function agent()
{
    return new Agent;
}

function browser()
{
    return (new Agent)->browser();
}

function get_content_by_comment_reply(CommentReply $reply)
{
    if ($reply && $reply->parent_id) {
        $reply = CommentReply::find($reply->parent_id);
        return get_content_by_comment_reply($reply);
    }

    $comment = $reply ? $reply->comment : null;

    return $comment ?: null;
}

function format_image_filename($filename)
{
    $extract = explode('.', $filename);

    return "{$extract[0]}{$extract[1]}"; 
}

function categories(array $filters = [], $key = 'res_categories')
{
    if (is_null($res_categories = Cache::get($key))) {
        $categories = Niche::whereEnabled(1);

        if (count($filters)) {
            foreach ($filters as $key => $filter) {
                $categories->where($key, $filter);
            }
        }
        $res_categories = $categories->orderBy('name', 'asc')->get();

        Cache::put($key, $res_categories, env('CACHE_TIME', 10));
    }

    return $res_categories;
}

function vehicle_types()
{
    return VehicleType::all();
}

function vehicle_makes()
{
    return VehicleMake::all();
}

function vehicle_models_by_make_id($make_id = null)
{
    return VehicleModel::whereMakeId($make_id)->get();
}

function vehicle_colors()
{
    return VehicleColor::all();
}

function camera_models()
{
    return CameraModel::oldest('name')->get();
}

function country_name_by_code($code)
{
    return Country::whereCode($code)->first()->name;
}

function subdomain()
{
    $subdomain = get_subdomain();

    return is_valid_subdomain() && !in_array($subdomain, config('app.valid_subdomains')) ? $subdomain : config('app.locale');
}

function is_valid_subdomain($subdomain = null)
{
    return in_array($subdomain ?: get_subdomain(), valid_subdomains());
}

function valid_subdomains()
{
    if (is_null($valid_locales = Cache::get('valid_locales'))) {
        $valid_locales = Language::all()->pluck('locale')->toArray();
        Cache::put('valid_locales', $valid_locales, env('CACHE_TIME', 1440));
    }

    return array_merge($valid_locales, config('app.valid_subdomains'));
}

function get_subdomain()
{
    $domain = env('APP_DOMAIN', 'comroads.com');
    $subdomain = config('app.locale');

    if ( $_SERVER['HTTP_HOST'] != $domain ) {
        $subdomain = str_replace('.'.$domain, '', $_SERVER['HTTP_HOST']);
    }

    return $subdomain;
}

function language_url($locale , $current)
{
    $domain = env('APP_DOMAIN', 'comroads.com');
    $path = \Request::path();
    $locale = $locale != 'en' ? $locale.'.' : 'www.'; 

    return rtrim("//{$locale}{$domain}/{$path}", '//');
}

function errorLog()
{
    return new ErrorLog;
}

function live_feeds($subdomain)
{
    $parser = new Parser();
    $parsed = $parser->xml(file_get_contents(public_path('jamcams-camera-list.xml')));
    $iconUrl = asset('images/categories/icon_44.png');
    $iconHoverUrl = asset('images/categories/hover/icon_44.png');

    $xmlFeeds = collect($parsed['cameraList']['camera'])->transform(function ($item, $key) use ($subdomain, $iconUrl, $iconHoverUrl) {
        //dd($item);
        if ($item['@attributes']['available']) {
            $slug = str_slug($item['location'] . '-' . $item['@attributes']['id']);

            $items['id'] = $item['@attributes']['id'];
            $items['latitude'] = (double)$item['lat'];
            $items['longitude'] = (double)$item['lng'];
            $items['category_icon_url'] = $iconUrl;
            $items['category_hover_icon_url'] = $iconHoverUrl;
            $items['title'] = $item['location'];    
            $items['url'] = base_url() . 'live-feed/' . $slug;

            if (!is_null($subdomain) && $subdomain != 'en') {
                $items['url'] = base_url($subdomain) . 'live-feed/' . $slug;
            }

            $items['country_code'] = 'GB';
            $items['thumbnail_url'] = 'https://s3-eu-west-1.amazonaws.com/jamcams.tfl.gov.uk/' . $item['file'];
            $items['source'] = 'jamcams-camera-list.xml';

            return $items;
        }
    });

    $dbFeeds = LiveFeed::all()->transform(function ($item, $key) use ($iconUrl, $iconHoverUrl, $subdomain) {
        $slug = str_slug($item->title . '-' . $item->id);

        $items['id'] = $item->id;
        $items['title'] = $item->title;
        $items['latitude'] = $item->latitude;
        $items['longitude'] = $item->longitude;
        $items['category_icon_url'] = $iconUrl;
        $items['category_hover_icon_url'] = $iconHoverUrl;
        $items['url'] = base_url() . 'live-feed/' . $slug;

        if (!is_null($subdomain) && $subdomain != 'en') {
            $items['url'] = base_url($subdomain) . 'live-feed/' . $slug;
        }

        $items['country_code'] = $item->country_code;
        $items['thumbnail_url'] = $item->thumb_url;
        $items['source'] = 'db';

        return $items;
    });

    return $xmlFeeds->merge($dbFeeds);
}

function format_bytes($bytes, $precision = 2) { 
    $units = array('B', 'KB', 'MB', 'GB', 'TB'); 

    $bytes = max($bytes, 0); 
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
    $pow = min($pow, count($units) - 1); 

    // Uncomment one of the following alternatives
    $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow)); 

    return [
        'size' => round($bytes, $precision),
        'unit' => $units[$pow]
    ]; 
} 