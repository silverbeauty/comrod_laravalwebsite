<?php

namespace App\Http\Controllers;

use Cache;
use App\City;
use App\User;
use App\Image;
use App\Niche;
use App\Region;
use App\Comment;
use App\Content;
use App\Country;
use App\OldUser;
use Carbon\Carbon;
use App\OldContent;
use App\ContentView;
use App\CommentReply;
use App\ContentImage;
use App\ContentNiche;
use App\LicensePlate;
use App\Http\Requests;
use App\ReportedContent;
use App\Services\Tinify;
use App\SuggestedLocation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\EditContentRequest;

class ApiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => [
            'postSuggestLocation',
            'getSearchCityByCountry',
            'getRegionsByCountry',
            'postReportContent',
            'getUpdateUsersTable',
            'getMapContents',
        ]]);
    }      

    public function postWriteComment(Request $request)
    {
        $this->validate($request, [
            'content_id' => 'required|exists:contents,id,disable_comments,0',
            'body' => 'required'
        ]);

        $user = $request->user();

        $content = Content::findOrFail($request->content_id);
        $comments = $content->comments;

        $new_comment = $content->addComment(new Comment([
            'user_id' => $user->id,
            'body' => $request->body,
            'ip' => $request->ip(),
        ]));

        $new_comment->recordActivity('discussion', 'you_commented', null, true, true);

        if ($content->user_id != $user->id) {
            $new_comment->recordActivity('discussion', 'commented_on_your_video', $content->user_id);
        }

        if (count($comments) > 1) {
            foreach ($comments as $comment) {
                if ($comment->user_id != $user->id) {
                    $new_comment->recordActivity('discussion', 'commented_on_video_you_commented', $comment->user_id);
                }
            }
        }        

        return [
            'id' => $new_comment->id,
            'body' => $request->body,
            'avatar' => $user->small_avatar,
            'username' => $user->username,
            'user_profile_url' => $user->url,
            'date' => $new_comment->created_at->diffForHumans(),
            'level' => 1,
            'total_comments' => $content->total_comments + 1
        ];
    }

    public function postWriteReply(Request $request)
    {
        $this->validate($request, [
            'comment_id' => 'required|exists:comments,id',
            'body' => 'required'
        ]);

        $user = $request->user();
        $parent_id = null;
        $model = $request->level == 1 ? 'App\Comment' : 'App\CommentReply';

        $comment = $model::findOrFail($request->comment_id);
        $replies = $comment->replies;

        $new_reply = $comment->addReply(new CommentReply([
            'user_id' => $user->id,
            'body' => $request->body,
            'ip' => $request->ip()
        ]));

        $new_reply->recordActivity('discussion', 'you_replied', null, true, true);

        if ($comment->user_id != $user->id) {
            $new_reply->recordActivity('discussion', 'replied_you', $comment->user_id);
        }

        if (count($replies) > 1) {
            foreach ($replies as $reply) {
                if ($reply->user_id != $user->id) {
                    $new_reply->recordActivity('discussion', $request->level == 1 ? 'replied_on_comment_you_replied' : 'replied_on_replied_you_replied', $reply->user_id);
                }
            }
        }

        return [
            'id' => $new_reply->id,
            'body' => $request->body,
            'avatar' => $user->small_avatar,
            'username' => $user->username,
            'user_profile_url' => $user->url,
            'date' => $new_reply->created_at->diffForHumans(),
            'level' => 2,
        ];
    }

    public function postLikeComment(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:comments'
        ]);

        $comment = Comment::findOrFail($request->id);
        $user = $request->user();
        
        $votes = $comment->handleLikeDislike($user, 'like');

        return [
            'total_likes' => $votes->total_likes,
            'total_dislikes' => $votes->total_dislikes,
        ];
    }

    public function postDislikeComment(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:comments'
        ]);

        $comment = Comment::findOrFail($request->id);
        $user = $request->user();
        
        $votes = $comment->handleLikeDislike($user, 'dislike');

        return [
            'total_likes' => $votes->total_likes,
            'total_dislikes' => $votes->total_dislikes,
        ];
    }

    public function postLikeReply(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:comment_replies'
        ]);

        $comment = CommentReply::findOrFail($request->id);
        $user = $request->user();
        
        $votes = $comment->handleLikeDislike($user, 'like');

        return [
            'total_likes' => $votes->total_likes,
            'total_dislikes' => $votes->total_dislikes,
        ];
    }

    public function postDislikeReply(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:comment_replies'
        ]);

        $comment = CommentReply::findOrFail($request->id);
        $user = $request->user();
        
        $votes = $comment->handleLikeDislike($user, 'dislike');

        return [
            'total_likes' => $votes->total_likes,
            'total_dislikes' => $votes->total_dislikes,
        ];
    }

    public function postLikeContent(Request $request)
    {
        if (is_null($content = Cache::get('video_content_'.$request->id))) {
            $content = Content::findOrFail($request->id);
        }
        
        $user = $request->user();
        
        $votes = $content->handleLikeDislike($user, 'like');

        Cache::put('video_content_'.$request->id, $votes, env('CACHE_TIME', 10));

        return [
            'total_likes' => $votes->total_likes,
            'total_dislikes' => $votes->total_dislikes,
        ];
    }

    public function postDislikeContent(Request $request)
    {
        if (is_null($content = Cache::get('video_content_'.$request->id))) {
            $content = Content::findOrFail($request->id);
        }
        $user = $request->user();
        
        $votes = $content->handleLikeDislike($user, 'dislike');
        Cache::put('video_content_'.$request->id, $votes, env('CACHE_TIME', 10));

        return [
            'total_likes' => $votes->total_likes,
            'total_dislikes' => $votes->total_dislikes,
        ];
    }

    public function postSuggestLocation(Request $request)
    {
        $this->validate($request, [
            'content_id' => 'required|exists:contents,id',
            'country_code' => 'required|exists:countries,code',
            'region_code' => 'required_if:country_code,AU,US,CA',
            'city_name' => 'required'
        ]);

        $user = $request->user();

        $request->merge(['user_id' => $user ? $user->id : null]);

        SuggestedLocation::create($request->all());

        return [
            'success_title' => trans('app.thank_you'),
            'success_body' => trans('video.suggested_location_pending'),
        ];
    }

    public function getSearchCityByCountry(Request $request)
    {
        $cities = City::whereCountryCode($request->country_code);

        if (!empty($request->region_code)) {
            $cities->whereRegionCode($request->region_code);
        }

        $cities = $cities->where('name', 'like', '%'.$request->term.'%')
                    ->groupBy('name')
                    ->take(5)
                    ->get();

        foreach ($cities as $key => $city) {
            $cities[$key]['id'] = $city->id;
            $cities[$key]['label'] = $city->name;
        }

        return $cities;
    }

    public function getSearchLicensePlate(Request $request)
    {
        $licenses = LicensePlate::where('name', 'like', '%'.$request->term.'%')->get();

        foreach ($licenses as $key => $license) {
            $licenses[$key]['id'] = $license->id;
            $licenses[$key]['label'] = $license->name;
        }

        return $licenses;
    }

    public function getRegionsByCountry(Request $request)
    {
        return Region::whereCountryCode($request->country_code)->get();
    }

    public function postReportContent(Request $request)
    {
        $user = $request->user();

        $this->validate($request, [
            'content_id' => 'required|exists:contents,id',
            'name' => is_null($user) ? 'required' : '',
            'email' => is_null($user) ? 'required|email' : '',
            'reason_id' => 'required|exists:reasons,id,type,report_content',
            'message' => 'required'
        ]);

        $request->merge([
            'user_id' => $user ? $user->id : null,
            'ip' => $request->ip()
        ]);

        $report = ReportedContent::create($request->all());

        return [
            'success_title' => trans('app.thank_you'),
            'success_body' => trans('app.we_will_take_action')
        ];
    }

    public function postDiscussionMarkRead(Request $request)
    {
        return $request->user()->activities()->whereType('discussion')->update(['read' => 1]);        
    }

    public function postDeleteTempUploadedVideo()
    {
        if (session()->has('video_filename')) {
            unlink(config('app.video_upload_path') . session()->pull('video_filename'));
        }
    }

    public function postDeleteTempUploadedPhoto(Request $request)
    {
        if ($request->filename) {
            $user = $request->user();

            if ($request->content_id) {
                $content = $user->contents()->whereId($request->content_id)->firstOrFail();
                $image = $content->images()->whereId($request->id);
                $image->delete();
            }

            delete_dir(config('app.gallery_path') . remove_extension($request->filename));

            if (session()->has('photos')) {
                foreach (session('photos') as $key => $filename) {
                    if ($filename == $request->filename) {
                        session()->forget('photos.'.$key);
                    }
                }

                if (count(session('photos')) == 0) {
                    session()->forget('photos');
                }
            }
        }
    }

    public function getVehicleMakeModels(Request $request)
    {
        return vehicle_models_by_make_id($request->make_id);
    }

    public function postEditUserProfile(Request $request)
    {
        $user = $request->user();        

        $this->validate($request, [
            'username' => 'required|unique:users,username,'.$user->id,
            'birth_day' => 'date',
            'gender' => 'in:Male,Female',
            'country_code' => 'exists:countries,code'
        ]);

        $user->update($request->all());
        $user->updateSlug($request->username);

        return [
            'success_title' => trans('app.success'),
            'success_body' => trans('app.changes_saved')
        ];
    }

    public function postEditContent(EditContentRequest $request, Tinify $tinify)
    {
        $user = $request->user();
        $content = Content::findOrFail($request->id);

        if (!$user->own($content->user_id)) {
            return response(['message' => 'You don\'t have permission to edit this '.$content->type], 422);
        }

        $embed_type = $request->embed_type;
        $embed_type = empty($embed_type) ? null : $embed_type;
        $embed_id = null;        

        if ($embed_type == 'vidme') {
            $embed_id = vidme_id($request->vidme_url);            
        }

        if ($embed_type == 'youtube') {
            $embed_id = youtube_id($request->youtube_url);
        }

        $request->merge([
            'slug' => str_slug($request->title),
            'ip' => $request->ip(),
            'embed_id' => $embed_id,
            'embed_type' => $embed_type,
            'disable_comments' => $request->disable_comments,
            'disable_map' => $request->disable_map,
            'private' => $request->private,
            'offence_date' => $request->offence_date.' '.$request->offence_time,
        ]);

        $content->update($request->all());        

        if ($request->type == 'photo' && session()->has('photos')) {
            $content->addImages(session()->pull('photos'));
        }

        if ($request->type == 'video' && session()->has('video_filename') && is_null($embed_type)) {
            $content->changeVideo(session()->pull('video_filename'));
        }

        $content->deleteCategories();

        if (!is_null($request->categories)) {
            foreach ($request->categories as $key => $category_id) {
                $content->addCategory(['niche_id' => $category_id]);                
            }
        } else {
            $content->addCategory(['niche_id' => 8]);
        }

        $license_plate = new LicensePlate;

        
        $content->deletePlates();
            
        if ($request->licenses) {
            foreach ($request->licenses as $key => $plate) {
                if (!empty($plate['name'])) {
                    $processed_plate = $license_plate->process($plate);
                    $content->addPlate(['license_id' => $processed_plate->id]);
                }
            }
        }

        session(['content_updated' => true]);



        return [
            'success_title' => trans('app.success'),
            'success_body' => trans('app.changes_saved'),
            'redirect' => $content->url
        ];
    }

    public function postDeleteVideo(Request $request)
    {
        $user = $request->user();
        $video = $user->videos()->whereId($request->id)->firstOrFail();
        $video->delete();

        return [
            'success_title' => trans('app.success'),
            'success_body' => trans('video.video_deleted_message'),
            'redirect' => $user->url
        ];   
    }

    public function postDeletePhoto(Request $request)
    {
        $user = $request->user();
        $photo = $user->photos()->whereId($request->id)->firstOrFail();
        $photo->delete();

        return [
            'success_title' => trans('app.success'),
            'success_body' => trans('video.photo_deleted_message'),
            'redirect' => $user->url
        ];   
    }

    public function getAutocompleteUsers(Request $request)
    {
        $term = $request->term;

        $users = User::where('username', 'like', '%'.$term.'%')
                    ->orWhere('first_name', 'like', '%'.$term.'%')
                    ->orWhere('last_name', 'like', '%'.$term.'%')
                    ->orWhere('email', 'like', '%'.$term.'%')
                    ->take(10)
                    ->get();

        $users = $users->map(function ($item, $key) {
            $new_item['label'] = $item->username;            
            $new_item['avatar'] = $item->small_avatar;

            return $new_item;
        });

        return $users;
    }

    public function getMapContents(Request $request)
    {
        $content_type = $request->map_content_type;
        $page = $request->page;
        $perPage = $request->per_page;
        $offset = $page == 1 ? 0 : ($perPage * $page) + 1;
        $total_pages = $request->total_pages;
        $total_contents = $request->total_contents;
        $map_contents = [];
        $i = 0;
        while (true) {
            if (Cache::has($content_type . '_map_contents_' . $i . '_' . $page)) {
                if (empty($map_contents)) {
                    $map_contents = Cache::get($content_type . '_map_contents_' . $i . '_' . $page);
                } else {
                    $items = Cache::get($content_type . '_map_contents_' . $i . '_' . $page);

                    $map_contents = array_merge($map_contents, $items);
                }
                $i++;
            } else {
                break;
            }
        }        
        
        if (empty($map_contents)) {
            $map_contents = Content::with(['images', 'categories.category', 'country', 'region'])
                            ->viewable()
                            ->withLatLng()
                            ->skip($offset)
                            ->take($perPage)
                            ->get();
            $for = $map_contents;
            foreach ($for->chunk(200) as $key => $chunk_videos) {
                Cache::put($content_type . '_map_contents_' . $key . '_' . $page, map_info($chunk_videos), env('CACHE_TIME', 10));
            }
            $map_contents = map_info($map_contents);
        }

        foreach ($map_contents as $key => $map_content) {
            $map_contents[$key]['latitude'] = (double)$map_content['latitude'];
            $map_contents[$key]['longitude'] = (double)$map_content['longitude'];
        }

        return $map_contents;
    }
}
