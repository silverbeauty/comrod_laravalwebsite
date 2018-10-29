<?php

namespace App\Traits;

use App\Ad;
use App\User;
use App\Comment;
use App\Content;
use App\Language;
use App\LiveFeed;
use App\CommentReply;
use App\ReportedContent;
use App\SuggestedLocation;
use App\ContentLicensePlate;
use App\ContentInactiveEmbed;
use Illuminate\Support\Facades\DB;
use Yajra\Datatables\Datatables as Datatable;
use Waavi\Translation\Repositories\LanguageRepository;
use Waavi\Translation\Repositories\TranslationRepository;

trait Datatables
{
    public function getDatatablesAds()
    {
        $ads = Ad::withTrashed()->get();

        return Datatable::of($ads)
        ->editColumn('code', function ($item) {
            return htmlentities($item->code);
        })
        ->addColumn('status', function ($item) {
            return $item->trashed() ? '<span class="label label-danger">Deleted</span>' : '<span class="label label-success">Active</span>';
        })
        ->addColumn('actions', function ($item) {
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
                            <li>
                                <a
                                    data-toggle="modal"
                                    data-target="#editAdModal"
                                    data-backrop="static"
                                    data-content="'.htmlentities(json_encode(['id' => $item->id, 'label' => $item->label, 'code' => $item->code])).'"
                                >Edit</a>
                            </li>';
            if ($item->trashed()) {
            $menu .= '      <li>
                                <a
                                    class="confirm-action"
                                    data-confirm-title="Are you sure?"
                                    data-confirm-body="You are about to restore this ad"
                                    data-confirm-button-text="Yes, restore it"
                                    data-ajax-data="'.htmlentities(json_encode(['id' => $item->id])).'"
                                    data-url="'.route('admin::postRestoreAd').'"
                                    data-reload="true"
                                >Restore</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a
                                    class="confirm-action"
                                    data-confirm-title="Are you sure?"
                                    data-confirm-body="You are about to delete this ad permanently"
                                    data-confirm-button-text="Yes, delete it"
                                    data-ajax-data="'.htmlentities(json_encode(['id' => $item->id])).'"
                                    data-url="'.route('admin::postForceDeleteAd').'"
                                    data-reload="true"
                                >Delete Permanently</a>
                            </li>';
            } else {
            $menu .= '      <li>
                                <a
                                    class="confirm-action"
                                    data-confirm-title="Are you sure?"
                                    data-confirm-body="You are about to delete this ad"
                                    data-confirm-button-text="Yes, delete it"
                                    data-ajax-data="'.htmlentities(json_encode(['id' => $item->id])).'"
                                    data-url="'.route('admin::postDeleteAd').'"
                                    data-reload="true"
                                >Delete</a>
                            </li>';
            }

            $menu .= '  </ul>
                    </div>';
            return $menu;
        })
        ->make(true);        
    }

    public function getDatatablesInactiveEmbed()
    {
        $contents = ContentInactiveEmbed::with('content.owner')->get();

        return Datatable::of($contents)
        ->editColumn('title', function ($item) {
            return '<a href="'.route('admin::getContentSettings', [$item->content->id]).'">'.$item->content->title.'</a>';
        })
        ->addColumn('uploader', function ($item) {
            $owner = $item->content->owner;
            return '<a href="'.$owner->url.'" target="_blank">'.$owner->username.'</a>';
        })
        ->addColumn('status', function ($item) {
            $content = $item->content;

            if ($content->is_pending) {
                return '<span class="label label-warning">Pending</span>';
            }

            if ($content->is_published) {
                return '<span class="label label-success">Published</span>';
            }

            if ($content->trashed()) {
                return '<span class="label label-danger">Deleted</span>';
            }
        })
        ->addColumn('actions', function ($item) {
            return manage_content_menu($item->content);
        })
        ->addColumn('type', function ($item) {
            return $item->content->type;
        })
        ->make(true);
    }

    public function getDatatablesReportedContents()
    {
        $contents = ReportedContent::with('content')->get();

        return Datatable::of($contents)
        ->editColumn('title', function ($item) {
            return '<a href="'.route('admin::getContentSettings', [$item->content->id]).'">'.$item->content->title.'</a>';
        })
        ->addColumn('reporter', function ($item) {
            $owner = $item->owner;

            if ($owner) {
                return '<a href="'.$owner->url.'" target="_blank">'.$owner->username.'</a>';
            }

            return '<a href="mailto:'.$item->email.'" target="_blank">'.$item->name.'</a>';
        })
        ->addColumn('reason', function ($item) {
            return $item->reason->label;
        })
        ->addColumn('message', function ($item) {
            return $item->message;
        })
        ->addColumn('status', function ($item) {
            $content = $item->content;

            if ($content->is_pending) {
                return '<span class="label label-warning">Pending</span>';
            }

            if ($content->is_published) {
                return '<span class="label label-success">Published</span>';
            }

            if ($content->trashed()) {
                return '<span class="label label-danger">Deleted</span>';
            }
        })
        ->addColumn('actions', function ($item) {
            return manage_reported_content_menu($item->content, $item);
        })
        ->addColumn('type', function ($item) {
            return $item->content->type;
        })
        ->make(true);
    }

    public function getDatatablesSuggestedLocations()
    {
        return Datatable::of(SuggestedLocation::has('content')->with('content.country', 'owner', 'country')->get())        
        ->addColumn('country', function ($item) {
            $content = $item->content;
            return '
                C: <span class="text-success">'.$content->country_name.'</span><br/>
                S: <span class="text-danger">'.$item->country->name.'</span>
            ';
        })
        ->addColumn('state', function ($item) {
            $content = $item->content;
            $state = $item->state_name ?: 'Not available';

            return '
                C: <span class="text-success">'.$content->state_name.'</span><br/>
                S: <span class="text-danger">'.$state.'</span>
            ';
        })
        ->addColumn('city', function ($item) {
            $content = $item->content;
            return '
                C: <span class="text-success">'.$content->city_name.'</span><br/>
                S: <span class="text-danger">'.$item->city_name.'</span>
            ';
        })
        ->addColumn('latitude', function ($item) {
            $content = $item->content;
            return '
                C: <span class="text-success">'.$content->latitude.'</span><br/>
                S: <span class="text-danger">'.$item->latitude.'</span>
            ';
        })
        ->addColumn('longitude', function ($item) {
            $content = $item->content;
            return '
                C: <span class="text-success">'.$content->longitude.'</span><br/>
                S: <span class="text-danger">'.$item->longitude.'</span>
            ';
        })
        ->addColumn('user', function ($item) {
            $owner = $item->owner;

            if (!is_null($owner)) {
                return '<a href="'.$owner->url.'" target="_blank">'.$owner->username.'</a>';
            }

            return 'non-member';
        })
        ->editColumn('status', function ($item) {
            if ($item->status == 'Approved') {
                return '<span class="label label-success">'.$item->status.'</span>';
            }

            return '<span class="label label-warning">'.$item->status.'</span>';
        })
        ->addColumn('actions', function ($item) {
            $content = $item->content;

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
                            <li>
                                <a href="'.$content->url.'" target="_blank">View</a>
                            </li>';
            if ($item->status == 'Pending') {
            $menu .= '      <li>
                                <a
                                    class="confirm-action"
                                    data-confirm-title="Are you sure?"
                                    data-confirm-body="You are about to approve this suggested location"
                                    data-confirm-button-text="Yes, approve it"
                                    data-ajax-data="'.htmlentities(json_encode(['id' => $item->id])).'"
                                    data-url="'.route('admin::postApproveSuggestedLocation').'"
                                    data-reload="true"
                                >Approve</a>
                            </li>';
            }
            $menu .= '      
                            <li role="separator" class="divider"></li>
                            <li>
                                <a
                                    class="confirm-action"
                                    data-confirm-title="Are you sure?"
                                    data-confirm-body="You are about to delete this suggested location"
                                    data-confirm-button-text="Yes, delete it"
                                    data-ajax-data="'.htmlentities(json_encode(['id' => $item->id])).'"
                                    data-url="'.route('admin::postDeleteSuggestedLocation').'"
                                    data-reload="true"
                                >Delete</a>
                            </li>';
            $menu .= '  </ul>
                    </div>';
            return $menu;
        })
        ->make(true);
    }

    public function getDatatablesLanguages()
    {
        return Datatable::of(Language::withTrashed()->get())
        ->addColumn('actions', function ($item) {
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
                            <li>
                                <a
                                    data-toggle="modal"
                                    data-target="#editLanguageModal"
                                    data-backrop="static"
                                    data-content="'.htmlentities(json_encode([
                                        'id' => $item->id,
                                        'locale' => $item->locale,
                                        'name' => $item->name,
                                        'country_code' => $item->country_code,
                                        'url' => $item->url                                        
                                    ])).'"
                                >Edit</a>
                            </li>';
            if ($item->trashed()) {
            $menu .= '      <li>
                                <a
                                    class="confirm-action"
                                    data-confirm-title="Are you sure?"
                                    data-confirm-body="You are about to restore this language"
                                    data-confirm-button-text="Yes, restore it"
                                    data-ajax-data="'.htmlentities(json_encode(['id' => $item->id])).'"
                                    data-url="'.route('admin::postRestoreLanguage').'"
                                    data-reload="true"
                                >Restore</a>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li>
                                <a
                                    class="confirm-action"
                                    data-confirm-title="Are you sure?"
                                    data-confirm-body="You are about to delete this language permanently"
                                    data-confirm-button-text="Yes, delete it"
                                    data-ajax-data="'.htmlentities(json_encode(['id' => $item->id])).'"
                                    data-url="'.route('admin::postForceDeleteLanguage').'"
                                    data-reload="true"
                                >Delete Permanently</a>
                            </li>';
            } else {
            $menu .= '      <li>
                                <a
                                    class="confirm-action"
                                    data-confirm-title="Are you sure?"
                                    data-confirm-body="You are about to delete this language"
                                    data-confirm-button-text="Yes, delete it"
                                    data-ajax-data="'.htmlentities(json_encode(['id' => $item->id])).'"
                                    data-url="'.route('admin::postDeleteLanguage').'"
                                    data-reload="true"
                                >Delete</a>
                            </li>';
            }

            $menu .= '  </ul>
                    </div>';
            return $menu;
        })
        ->addColumn('status', function ($item) {
            $status = '<span class="label label-success">Active</span>';

            if ($item->trashed()) {
                $status = '<span class="label label-danger">Deleted</span>';
            }

            return $status;
        })
        ->make(true);
    }

    public function getDatatablesContentTranslations($locale, $filter)
    {
        $exclude_country_codes = $this->logged_user->translatorExcludedCountries->pluck('country_code');
        $contents = Content::viewable()->whereNotIn('country_code', $exclude_country_codes)->get();


        if ($filter == 'filter' && $locale != 'en') {
            $contents = $contents->filter(function ($item) use($locale) {
                if (
                    (isset($item->title_translated[$locale]) && empty($item->title_translated[$locale])) ||
                    (isset($item->description_translated[$locale]) && empty($item->description_translated[$locale])) ||
                    !isset($item->title_translated[$locale]) ||
                    !isset($item->description_translated[$locale])
                ) {
                    return $item;
                }
            });
        }
        
        return Datatable::of($contents)
        ->editColumn('content', function ($item) use($locale) {
            $title_label = $item->title;
            $title_text = isset($item->title_translated[$locale]) ? $item->title_translated[$locale] : null;
            $title_text = $locale == 'en' ? $title_label : $title_text;
            $description_label = $item->description;
            $description_text = isset($item->description_translated[$locale]) ? $item->description_translated[$locale] : null;
            $description_text = $locale == 'en' ? $description_label : $description_text;        

            return '
                <form
                    action="'.route('admin::postUpdateContentTranslation').'"
                    method="post"
                    class="form-block form-ajax"
                    data-clear="false"
                >
                    <input type="hidden" name="id" value="'.$item->id.'">
                    <input type="hidden" name="locale" value="'.$locale.'">
                    <div class="form-group">
                        <label><b>Original Title:</b> '.$title_label.'</label>
                        <textarea
                            name="titles['.$locale.']"
                            class="form-control"
                            rows="4"
                        >'.$title_text.'</textarea>                        
                    </div>
                    <div class="form-group">
                        <label><b>Original Description:</b> '.$description_label.'</label>
                        <textarea
                            name="descriptions['.$locale.']"
                            class="form-control"
                            rows="4"
                        >'.$description_text.'</textarea>                        
                    </div> 
                    <div class="form-group text-right">
                        <button
                            type="submit"
                            class="btn btn-success"
                            data-loading-text="'.button_loading('Saving...').'"
                        >Save</button>                                                
                    </div>                   
                </form>
            ';       
        })
        ->make(true);
    }

    public function getDatatablesTranslations(TranslationRepository $trans, $locale, $filter)
    {
        $translations = $filter == 'filter' ? $trans->untranslated($locale) : $trans->allByLocale($locale)->merge($trans->untranslated($locale));

        return Datatable::of($translations)
        ->editColumn('text', function ($item) use($locale, $trans) {
            $text = $locale == $item->locale ? $item->text : null;
            $translation = $trans->translateText($item->text, 'en', 'en');
            $label = count($translation) ? $translation[0] : $trans->translateText($item->text, $locale, 'en')[0];         

            return '
                <form
                    action="'.route('admin::postUpdateTranslation').'"
                    method="post"
                    class="form-block form-ajax"
                    data-clear="false"
                >
                    <input type="hidden" name="id" value="'.$item->id.'">
                    <input type="hidden" name="locale" value="'.$locale.'">
                    <div class="form-group">
                        <label>Key: '.$item->group.'.'.$item->item.'</label><br/>
                        <label>English: '.nl2br(htmlentities($label)).'</label>
                        <textarea
                            name="text"
                            class="form-control"
                            rows="4"
                        >'.$text.'</textarea>                        
                    </div> 
                    <div class="form-group text-right">
                        <button
                            type="submit"
                            class="btn btn-success"
                            data-loading-text="'.button_loading('Saving...').'"
                        >Save</button>                                                
                    </div>                   
                </form>
            ';       
        })
        ->make(true);
    }

    public function getDatatablesTranslators()
    {
        $translators = User::withTrashed()->select(['id', 'username', 'email', 'created_at', 'deleted_at'])
                        ->whereHas('roles', function ($query) {
                            $query->whereId(3);
                        })->get();

        return Datatable::of($translators)
        ->editColumn('created_at', function ($user) {
            return $user->created_at->toFormattedDateString();
        })    
        ->addColumn('actions', function ($user) {
            return manage_translator_menu($user);
        })
        ->addColumn('status', function ($user) {
            return $user->trashed() ? '<span class="label label-danger">Deleted</span>' : '<span class="label label-success">Active</span>';
        })
        ->addColumn('languages', function ($user) {
            $languages = $user->languages;
            $default_languages = null;

            if ($languages) {
                foreach ($languages as $language) {
                    $default_languages .= $language->name.', ';
                }
            }

            return !is_null($default_languages) ? trim($default_languages, ', ') : 'None';
        })                    
        ->make(true);
    }

    public function getDatatablesComments()
    {
        $comments = Comment::all()->merge(CommentReply::all());
        
        return Datatable::of($comments)
        ->editColumn('created_at', function ($comment) {
            return $comment->created_at->toFormattedDateString();
        })
        ->addColumn('actions', function ($comment) {
            return manage_comment_menu($comment);
        })
        ->addColumn('user', function ($comment) {
            $owner = $comment->owner;
            return '<a href="'.$owner->url.'" target="_blank">'.$owner->username.'</a>';
        })
        ->make(true); 
    }

    public function getUsersApi()
    {
        $users = User::withTrashed()->select(['id', 'username', 'email', 'registration_ip', 'created_at', 'deleted_at'])->get();

        return Datatable::of($users)
        ->editColumn('created_at', function ($user) {
            return $user->created_at->toFormattedDateString();
        })    
        ->addColumn('actions', function ($user) {
            return manage_user_menu($user);
        })
        ->addColumn('status', function ($user) {
            return $user->trashed() ? '<span class="label label-danger">Deleted</span>' : '<span class="label label-success">Active</span>';
        })
        ->addColumn('roles', function($user) {
            $roles = 'User, ';            
            foreach ($user->roles as $role) {
                $roles .= $role->label.', ';
            }
            return trim($roles, ', ');
        })            
        ->make(true);
    }

    public function getDatatablesMultipleViolations()
    {
        $plates_id = ContentLicensePlate::select(DB::raw('*, count(*) as plate_count'))
                    ->groupBy('license_id')
                    ->having('plate_count', '>', 1)                    
                    ->get()
                    ->pluck('license_id');

        $plates = ContentLicensePlate::with('content.owner', 'info')
                    ->select(DB::raw('*, count(*) as content_count'))
                    ->whereIn('license_id', $plates_id)
                    ->groupBy('content_id')
                    ->having('content_count', '=', 1)
                    ->has('info')
                    ->has('content')                    
                    ->get();
        
        return Datatable::of($plates)
        ->editColumn('title', function ($item) {
            return '<a href="'.route('admin::getContentSettings', [$item->content->id]).'">'.$item->content->title.'</a>';
        })
        ->addColumn('id', function ($item) {
            return $item->content->id;
        })
        ->addColumn('plate', function ($item) {
            return $item->info->name;
        })
        ->addColumn('type', function ($item) {
            return $item->content->type;
        })
        ->addColumn('uploader', function ($item) {
            $owner = $item->content->owner;
            return $owner ? '<a href="'.$owner->url.'" target="_blank">'.$owner->username.'</a>' : null;
        })
        ->addColumn('status', function ($item) {
            $content = $item->content;

            if ($content->is_pending) {
                return '<span class="label label-warning">Pending</span>';
            }

            if ($content->is_published) {
                return '<span class="label label-success">Published</span>';
            }

            if ($content->trashed()) {
                return '<span class="label label-danger">Deleted</span>';
            }
        })
        ->addColumn('actions', function ($item) {
            return manage_content_menu($item->content);
        })
        ->make(true);
    }

    public function getContentsDeletedApi()
    {
        $contents = Content::onlyTrashed()->select(['id', 'user_id', 'title', 'approved', 'type', 'embed_type', 'slug', 'deleted_at'])->get();

        return Datatable::of($contents)
        ->editColumn('title', function ($content) {
            return '<a href="'.route('admin::getContentSettings', [$content->id]).'">'.$content->title.'</a>';
        })
        ->addColumn('uploader', function ($content) {
            $owner = $content->owner;
            return $owner ? '<a href="'.$owner->url.'" target="_blank">'.$owner->username.'</a>' : null;
        })
        ->addColumn('status', function ($content) {
            return '<span class="label label-danger">Deleted</span>';
        })
        ->addColumn('actions', function ($content) {
            return manage_content_menu($content);
        })
        ->make(true);
    }

    public function getDatatablesUnencodedContents()
    {
        $contents = Content::whereNull('encoded_date')
                    ->whereType('video')
                    ->whereNull('embed_type')
                    ->where('original_filename', '!=', '')
                    ->select(['id', 'user_id', 'title', 'approved', 'type', 'embed_type', 'slug', 'deleted_at'])
                    ->get();

        return Datatable::of($contents)
        ->editColumn('title', function ($content) {
            return '<a href="'.route('admin::getContentSettings', [$content->id]).'">'.$content->title.'</a>';
        })
        ->addColumn('uploader', function ($content) {
            $owner = $content->owner;
            return $owner ? '<a href="'.$owner->url.'" target="_blank">'.$owner->username.'</a>' : null;
        })
        ->addColumn('status', function ($content) {
            return '<span class="label label-danger">Deleted</span>';
        })
        ->addColumn('actions', function ($content) {
            return '<a class="btn btn-primary btn-ajax" data-url="'.route('admin::postEncodeContent').'" data-ajax-data='.json_encode(['id' => $content->id]).' data-loading-text="'.button_loading('Encoding...').'" data-reload="true">Encode</a>';
        })
        ->make(true);
    }

    public function getDatatablesPublishedLiveFeeds()
    {
        $feeds = LiveFeed::all();

        return Datatable::of($feeds)
        ->editColumn('title', function ($feed) {
            return '<a href="'.route('admin::getEditLiveFeed', [$feed->id]).'">'.$feed->title.'</a>';
        })
        ->editColumn('type', function ($feed) {
            return '<span class="label label-success">'.$feed->type.'</span>';
        })        
        ->addColumn('actions', function ($feed) {
            return manage_live_feed_menu($feed);
        })
        ->make(true);
    }

    public function getContentsPendingApi()
    {
        $contents = Content::select(['id', 'user_id', 'title', 'approved', 'type', 'embed_type', 'slug', 'source', 'deleted_at'])->whereApproved(0)->get();

        return Datatable::of($contents)
        ->editColumn('title', function ($content) {
            return '<a href="'.route('admin::getContentSettings', [$content->id]).'">'.$content->title.'</a>';
        })
        ->editColumn('source', function ($content) {
            return ucfirst($content->source);
        })
        ->addColumn('uploader', function ($content) {
            $owner = $content->owner;
            return $owner ? '<a href="'.$owner->url.'" target="_blank">'.$owner->username.'</a>' : null;
        })
        ->addColumn('status', function ($content) {
            return '<span class="label label-warning">Pending</span>';
        })
        ->addColumn('actions', function ($content) {
            return manage_content_menu($content);
        })
        ->make(true);
    }

    public function getContentsPublishedApi()
    {
        $contents = Content::select(['id', 'user_id', 'title', 'approved', 'type', 'embed_type', 'slug', 'deleted_at'])->whereApproved(1)->get();

        return Datatable::of($contents)
        ->editColumn('title', function ($content) {
            return '<a href="'.route('admin::getContentSettings', [$content->id]).'">'.$content->title.'</a>';
        })
        ->addColumn('uploader', function ($content) {
            $owner = $content->owner;
            return $owner ? '<a href="'.$owner->url.'" target="_blank">'.$owner->username.'</a>' : null;
        })
        ->addColumn('status', function ($content) {
            return '<span class="label label-success">Published</span>';
        })
        ->addColumn('actions', function ($content) {
            return manage_content_menu($content);
        })
        ->make(true);
    }

    public function getContentsPrivateApi()
    {
        $contents = Content::select(['id', 'user_id', 'title', 'approved', 'type', 'embed_type', 'slug', 'deleted_at'])
                    ->whereApproved(1)
                    ->wherePrivate(1)
                    ->get();

        return Datatable::of($contents)
        ->editColumn('title', function ($content) {
            return '<a href="'.route('admin::getContentSettings', [$content->id]).'">'.$content->title.'</a>';
        })
        ->addColumn('uploader', function ($content) {
            $owner = $content->owner;
            return $owner ? '<a href="'.$owner->url.'" target="_blank">'.$owner->username.'</a>' : null;
        })
        ->addColumn('status', function ($content) {
            return '<span class="label label-success">Published</span>';
        })
        ->addColumn('actions', function ($content) {
            return manage_content_menu($content);
        })
        ->make(true);
    }

    public function getContentsAppApi()
    {
        $contents = Content::select(['id', 'user_id', 'title', 'approved', 'type', 'embed_type', 'slug', 'deleted_at'])
                            ->whereApproved(1)
                            ->whereSource('mobile')
                            ->get();

        return Datatable::of($contents)
        ->editColumn('title', function ($content) {
            return '<a href="'.route('admin::getContentSettings', [$content->id]).'">'.$content->title.'</a>';
        })
        ->addColumn('uploader', function ($content) {
            $owner = $content->owner;
            return $owner ? '<a href="'.$owner->url.'" target="_blank">'.$owner->username.'</a>' : null;
        })
        ->addColumn('status', function ($content) {
            return '<span class="label label-success">Published</span>';
        })
        ->addColumn('actions', function ($content) {
            return manage_content_menu($content);
        })
        ->make(true);
    }

    public function getUsersActivity()
    {
        $users = User::select(['id', 'username', 'created_at', 'last_login', 'last_last_login', 'points', 'user_agent'])->get();

        return Datatable::of($users)
        ->editColumn('last_login', function ($user) {
            return !is_null($user->last_login) ? $user->last_login->toFormattedDateString() : null;
        })
        ->editColumn('created_at', function ($user) {
            return $user->created_at->toFormattedDateString();
        })
        ->addColumn('last_visit', function ($user) {
            return time_from_last_visit($user->last_login, $user->last_last_login);
        })
        ->addColumn('last_last_visit', function ($user) {
            return time_from_last_last_visit($user->last_last_login);
        })                
        ->make(true);
    }
}