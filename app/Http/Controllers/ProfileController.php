<?php

namespace App\Http\Controllers;

use Cache;
use App\User;
use JavaScript;
use App\Content;
use Carbon\Carbon;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function __construct()
    {
        carbon_set_locale();
        
        $this->middleware('auth', ['only' => [
            'getDiscussions',
            'getUserEditProfile',
            'getPhotoProfileEdit',
            'getVideoProfileEdit',
        ]]);

        $this->middleware('intended_url', ['only' => [
            'getContentProfile'   
        ]]);
    }

    public function getUserProfile(Request $request)
    {
        $id = last(explode('-', $request->slug));
        $loggedUser = $request->user();
        $loggedUserId = $loggedUser ? $loggedUser->id : null;

        if (is_null($profile = Cache::get('user_profile_'.$id))) {
            $profile = User::findOrFail($id);
            Cache::put('user_profile_'.$id, $profile, env('CACHE_TIME', 10));
        }             

        $map_contents = $profile->contents($loggedUserId)->with(['images.content', 'country', 'categories.category'])->latest();
        $main_contents = $profile->contents($loggedUserId)->with(['images.content', 'country', 'categories.category'])->latest();
        $data['profile'] = $profile;
        $data['total_videos'] = $profile->contents($loggedUserId)->whereType('video')->count();
        $data['total_photos'] = $profile->contents($loggedUserId)->whereType('photo')->count();
        $data['total_contents'] = $data['total_videos'] + $data['total_photos'];      
        $map_contents = map_info($map_contents->withLatLng()->get());        

        foreach ($map_contents as $key => $map_content) {
            $map_contents[$key]['lat'] = (double)$map_content['lat'];
            $map_contents[$key]['lng'] = (double)$map_content['lng'];
        }      

        JavaScript::put([
            'settings' => [
                'init_settings' => true,
                'reset_settings' => true,
                'ignore_filters' => true,
                'total_slots' => 9,
                'multiple_markers' => true,
                'map_element_id' => 'map',
                'map_icon' => null,
                'lat' => $map_contents ? $map_contents[0]['lat'] : null,
                'lng' => $map_contents ? $map_contents[0]['lng'] : null,
                'address' => null,
                'zoom' => 11,
                'content_id' => null,
                'categories' => [],
                'map_content_type' => 'any',
                'map_loading' => true,
                'use_country_name' => false,
                'logged_in' => Auth::check(),
                'watched' => null,
                'fit_bounds' => true,
                'map_contents' => $map_contents,
                'categories_icon_url' => 'http://jspl.comroads.com/images/categories/'
            ]
        ]);

        $data['contents'] = $main_contents->take(6)->get();

        return view('profiles.user', $data);
    }

    public function getUserEditProfile(Request $request)
    {
        return view('profiles.user_edit');
    }

    public function getUserUploads(Request $request)
    {
        $username = $request->slug;
        $data['profile'] = User::whereUsername($username)->firstOrFail();

         $contents = $data['profile']->contents()->latest();

        $data['contents'] = $contents->get();

        $map_contents = map_info($contents->withLatLng()->get());        

        foreach ($map_contents as $key => $map_content) {
            $map_contents[$key]['lat'] = (double)$map_content['lat'];
            $map_contents[$key]['lng'] = (double)$map_content['lng'];
        } 

        $js_vars = JavaScript::put([
            'settings' => [
                'init_settings' => true,
                'reset_settings' => true,
                'ignore_filters' => true,
                'total_slots' => 9,
                'multiple_markers' => true,
                'map_element_id' => 'map',
                'map_icon' => null,
                'lat' => $map_contents ? $map_contents[0]['lat'] : null,
                'lng' => $map_contents ? $map_contents[0]['lng'] : null,
                'address' => null,
                'zoom' => 11,
                'content_id' => null,
                'categories' => [],
                'map_content_type' => 'any',
                'map_loading' => true,
                'use_country_name' => false,
                'logged_in' => Auth::check(),
                'watched' => null,
                'fit_bounds' => true,
                'map_contents' => $map_contents,
                'categories_icon_url' => 'http://jspl.comroads.com/images/categories/'
            ]
        ]);

        return view('profiles.user_uploads', $data);
    }

    public function getUserVideos(Request $request)
    {
        $username = $request->slug;
        $data['profile'] = User::whereUsername($username)->firstOrFail();

        $videos = $data['profile']->videos()->latest();

        $data['videos'] = $videos->get();

        $map_contents = map_info($videos->withLatLng()->get());        

        foreach ($map_contents as $key => $map_content) {
            $map_contents[$key]['lat'] = (double)$map_content['lat'];
            $map_contents[$key]['lng'] = (double)$map_content['lng'];
        } 

        $js_vars = JavaScript::put([
            'settings' => [
                'init_settings' => true,
                'reset_settings' => true,
                'ignore_filters' => true,
                'total_slots' => 9,
                'multiple_markers' => true,
                'map_element_id' => 'map',
                'map_icon' => null,
                'lat' => $map_contents ? $map_contents[0]['lat'] : null,
                'lng' => $map_contents ? $map_contents[0]['lng'] : null,
                'address' => null,
                'zoom' => 11,
                'content_id' => null,
                'categories' => [],
                'map_content_type' => 'any',
                'map_loading' => true,
                'use_country_name' => false,
                'logged_in' => Auth::check(),
                'watched' => null,
                'fit_bounds' => true,
                'map_contents' => $map_contents,
                'categories_icon_url' => 'http://jspl.comroads.com/images/categories/'
            ]
        ]);

        return view('profiles.user_videos', $data);        
    }

    public function getUserPhotos(Request $request)
    {
        $username = $request->slug;
        $data['profile'] = User::whereUsername($username)->firstOrFail();

        $photos = $data['profile']->photos()->latest();

        $data['photos'] = $photos->get();

        $map_contents = map_info($photos->withLatLng()->get());        

        foreach ($map_contents as $key => $map_content) {
            $map_contents[$key]['lat'] = (double)$map_content['lat'];
            $map_contents[$key]['lng'] = (double)$map_content['lng'];
        } 

        $js_vars = JavaScript::put([
            'settings' => [
                'init_settings' => true,
                'reset_settings' => true,
                'ignore_filters' => true,
                'total_slots' => 9,
                'multiple_markers' => true,
                'map_element_id' => 'map',
                'map_icon' => null,
                'lat' => $map_contents ? $map_contents[0]['lat'] : null,
                'lng' => $map_contents ? $map_contents[0]['lng'] : null,
                'address' => null,
                'zoom' => 11,
                'content_id' => null,
                'categories' => [],
                'map_content_type' => 'any',
                'map_loading' => true,
                'use_country_name' => false,
                'logged_in' => Auth::check(),
                'watched' => null,
                'fit_bounds' => true,
                'map_contents' => $map_contents,
                'has_json_file' => false,
                'categories_icon_url' => 'http://jspl.comroads.com/images/categories/'
            ]
        ]);

        return view('profiles.user_photos', $data);
    }

    public function getVideoProfile(Request $request)
    {
        $data = $this->getContentProfile($request);        

        if (is_null($data)) {
            return redirect()->route('home');
        }

        $data['type'] = trans('video.video');
        $data['player'] = config('app.player');

        if ((bool)$request->minimal) {
            return view('profiles.content-minimal', $data);
        }

        if (is_rtl()) {
            return view('profiles.content-right', $data);
        }

        if ($request->player == 'test') {
            $data['player'] = 'test_player';
        }

        return view('profiles.content', $data);
    }

    public function getPhotoProfile(Request $request)
    {
        $data = $this->getContentProfile($request);
        
        if (is_null($data)) {
            return redirect()->route('home');
        }

        $data['type'] = trans('video.photo');     

        if (is_rtl()) {
            return view('profiles.content-right', $data);
        }
        
        return view('profiles.content', $data);
    }

    public function getVideoProfileEdit(Request $request)
    {
        $content = Content::findOrFail(last(explode('-', $request->slug)));
        $user = $request->user();

        if (!$user->own($content->user_id)) {
            return redirect($content->url);
        }

        $data = upload_content_default_data();
        $data['content'] = $content;
        $data['categories'] = $content->categories->toArray();
        $data['licenses'] = old('licenses', licenses($content->plates));
        $data['translated_type'] = strtolower(trans('video.video'));

        $user_geo = user_geo();

        JavaScript::put([
            'content_id' => $content->id,
            'dropzone_upload_text' => trans('video.dropbox_upload_text'),
            'dropzone_remove_video' => trans('video.dropzone_remove_video'),
            'dropzone_remove_photo' => trans('video.dropzone_remove_photo'),
            'dropzone_max_files_exceeded' => trans('video.dropzone_max_files_exceeded'),
            'thumbnail' => [
                ['url' => $content->thumbnail_url],
            ],
            'settings' => [
                'map_element_id' => 'map',
                'lat' => $content->latitude,
                'lng' => $content->longitude,
                'zoom' => 14,
                'default_marker' => true,
                'map_marker_draggable' => true,
                'map_marker_title' => trans('app.drag_me'),
                'map_icon' => $content->first_category_icon_url,
                'map_marker_events' => ['dragend'],
                'map_no_geometry' => trans('app.map_no_geometry'),
                'map_search' => true,
                'map_search_box_placeholder' => trans('video.search_google_maps')
            ]
        ]);

        return view('edit_video', $data);
    }

    public function getPhotoProfileEdit(Request $request)
    {
        $content = Content::findOrFail(last(explode('-', $request->slug)));
        $user = $request->user();

        if (!$user->own($content->user_id)) {
            return redirect($content->url);
        }

        $data = upload_content_default_data();
        $data['content'] = $content;
        $data['categories'] = $content->categories->toArray();
        $data['licenses'] = old('licenses', licenses($content->plates));
        $data['translated_type'] = strtolower(trans('video.photo'));

        $user_geo = user_geo();

        JavaScript::put([
            'dropzone_upload_text' => trans('video.dropbox_upload_text'),
            'dropzone_remove_photo' => trans('video.dropzone_remove_photo'),
            'dropzone_max_files_exceeded' => trans('video.dropzone_max_files_exceeded'),
            'photos' => $content->images->transform(function ($item, $key) use($content) {
                $item['url'] = $item->url($content->original_filename, 'medium');
                $item['size'] = $item->size($content->original_filename);
                return $item;
            }),
            'settings' => [
                'map_element_id' => 'map',
                'lat' => $content->latitude,
                'lng' => $content->longitude,
                'zoom' => 14,
                'default_marker' => true,
                'map_marker_draggable' => true,
                'map_marker_title' => trans('app.drag_me'),
                'map_icon' => $content->first_category_icon_url,
                'map_marker_events' => ['dragend'],
                'map_no_geometry' => trans('app.map_no_geometry'),
                'map_search' => true,
                'map_search_box_placeholder' => trans('video.search_google_maps')
            ]
        ]);

        return view('edit_photo', $data);
    }

    public function getContentProfile(Request $request)
    {
        $extracted_slug = explode('-', $request->slug);
        $id = end($extracted_slug);
        $user = $request->user();
        $subdomain = get_subdomain();
        $data['is_ajax'] = $request->ajax();
        $data['is_mobile'] = false;
        $map_contents = [];
        $contentCache = Cache::tags(['contents', 'content']);

        if (agent()->isMobile() || agent()->isTablet()) {
            $data['is_mobile'] = true;
        }
    
        if (is_null($content = $contentCache->get($subdomain.'_content_profile_'.$id)) || session()->has('content_updated')) {
            session()->forget('content_updated');
        
            $content = Content::find($id);            

            if (! $content) {
                return;
            }

            $contentCache->put($subdomain.'_content_profile_'.$id, $content, env('CACHE_TIME', 10));
        }

        if ($content->private && (($user && $user->id != $content->user_id) || is_null($user))) {
            return;
        }

        $data['content'] = $content;
        $data['content']->incrementTotalViews();
        $ip = $request->ip();

        if ($content->type == 'video') {
            if (! in_array($data['content']->id, session('watched', []))) {
                session()->push('watched', $data['content']->id);
            }

            if (!is_null($user) && !$user->isWatchedToday($data['content'])) {
                $user->addWatched($data['content']);
            } elseif(is_null($data['content']->isWatched($ip))) {
                $data['content']->addWatched($ip);
            }
        }

        $data['comments_sort_types'] = [
            'likes' => ['text' => trans('sorting.likes'), 'column' => 'total_likes'],
            'dislikes' => ['text' => trans('sorting.dislikes'), 'column' => 'total_dislikes'],
            'newest' => ['text' => trans('sorting.newest_first'), 'column' => 'created_at'],
            'oldest' => ['text' => trans('sorting.oldest_first'), 'column' => 'created_at'],
        ];

        $data['comments_sort_type'] = $request->sort ?: 'newest';

        $comments_cache_key = md5($id.$data['comments_sort_type']);

        
        $comments = $data['content']->comments()->with('replies', 'owner');
        
        if ($data['comments_sort_type'] == 'oldest') {
            $comments->oldest();
        } else {
            $comments->latest($data['comments_sort_types'][$data['comments_sort_type']]['column']);
        }
        $comments = $comments->get();
            
        
        $data['comments'] = $comments;
        $data['address'] = $content->address;

        if (! $data['is_ajax'] && ! $data['is_mobile']) {
            $data['category_icon_url'] = $content->first_category_icon_url;
            $ip = env('APP_ENV') == 'local' ? config('app.test_ip') : $request->ip();
            $user_geo = user_geo($ip);
            $data['country_code'] = $user_geo['country_code'];
            $data['country_name'] = $user_geo['country_name'];
            $data['category_filters'] = [];

            $relatedContentCache = Cache::tags(['contents', 'related_contents']);                        

            if (is_null($related = $relatedContentCache->get($subdomain.'_video_'.$id.'_related'))) {
                $related = $content->related();
                $relatedContentCache->put($subdomain.'_video_'.$id.'_related', $related, env('CACHE_TIME', 10));
            }

            $data['related'] = $related;

            $country_map_zoom = [
                'US' => 9,
                'CA' => 10,
                'IL' => 11,
                'AU' => 9
            ];

            $zoom = isset($country_map_zoom[$content->country_code]) ? $country_map_zoom[$content->country_code] : 12;
            $data['content_type'] = $content->type;

            $settings = [                
                'init_settings' => true,
                'reset_settings' => true,
                'ignore_filters' => true,
                'total_slots' => 3,
                'disable_map' => false,
                'multiple_markers' => true,
                'map_element_id' => 'contentProfileMap',
                'map_icon' => $content->first_category_hover_icon_url,
                'lat' => $content->latitude,
                'lng' => $content->longitude,
                'address' => $content->address,
                'zoom' => $zoom,
                'content_id' => $content->id,
                'categories' => [],
                'map_content_type' => 'any',
                'map_loading' => true,
                'default_marker' => true,
                'logged_in' => Auth::check(),
                'main_carousel_item' => 0,
                'watched' => !is_null($user) ? $user->watched->pluck('content_id') : [],
                'watchedLabel' => trans('app.watched'),
                'has_json_file' => true,
                'json_file' => asset_cdn(get_subdomain().'-map.json'),
                'layout' => 'v1',
                'categories_icon_url' => 'http://jspl.comroads.com/images/categories/'
            ];

            $data['js_vars'] = JavaScript::put([
                'settings' => $settings
            ]);

            // $data['pjax_js'] = JavaScript::put([
            //     'pjax_settings' => $settings
            // ]);
        }

        if (config('app.player') == 'flowplayer') {
            $data['flowplayer_settings'] = $request->hola ? $content->flowplayer_hola_settings : $content->flowplayer_settings;
        }

        return $data;
    }

    public function getDiscussions(Request $request)
    {   
        $discussions_activity = $request->user()->activities()->whereType('discussion');
        $discussions = $discussions_activity->with('activitable')->latest()->get();        

        return view('profiles.discussions', compact('discussions'));
    }

    public function getEmbed($id, Request $request)
    {
        if (is_null($content = Content::find($id))) {
            return 'Invalid embed url.';
        }
        return view('profiles.embed', compact('content'));
    }
}