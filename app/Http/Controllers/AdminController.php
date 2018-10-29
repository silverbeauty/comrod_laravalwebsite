<?php

namespace App\Http\Controllers;

use Cache;
use App\Ad;
use App\Role;
use App\User;
use App\Image;
use App\Niche;
use JavaScript;
use App\Comment;
use App\Content;
use App\Country;
use App\OldUser;
use App\Language;
use App\LiveFeed;
use App\OldContent;
use App\Permission;
use App\ContentView;
use App\VehicleType;
use App\CommentReply;
use App\ContentImage;
use App\ContentNiche;
use App\LicensePlate;
use App\VehicleColor;
use App\Http\Requests;
use App\ReportedContent;
use App\Jobs\EncodeVideo;
use App\SuggestedLocation;
use App\Traits\Datatables;
use App\Mailers\UserMailer;
use Illuminate\Http\Request;
use App\Traits\AdminDataMerge;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Artisan;
use App\Http\Requests\AdminEditContentRequest;
use Waavi\Translation\Repositories\LanguageRepository;
use Waavi\Translation\Repositories\TranslationRepository;

class AdminController extends Controller
{
    use AdminDataMerge, Datatables;

    protected $logged_user;
    protected $redirect;

    public function __construct()
    {
        $this->middleware('admin');

        $this->logged_user = Auth::user();
        $this->redirect = route('admin::getIndex');
    }

    public function getTest(Request $request)
    {
        echo '<form action="http://comroads.com/upload/upload-video" method="post" enctype="multipart/form-data">
            <input type="file" name="video" value="" placeholder="">
            <button type="submit">submit</button>
        </form>';
        //echo  sys_get_temp_dir();
        //echo phpinfo();

        // $video = Content::findOrFail(4920);

        // dd($video->files);
    }    

    protected function unauthorized()
    {
        return response(['message' => 'You are unauthorized to perform this action'], 422);
    }

    public function getIndex()
    {
        if ($this->logged_user->can('translate') && $this->logged_user->doesntHaveRoleOf(['super_admin', 'admin'])) {
            $locale = $this->logged_user->languages()->first()->locale;
            return redirect()->route('admin::getLocalization', ['locale' => $locale]);
        }

        return view('admin.dashboard');
    }

    public function getUsers(Request $request)
    {
        if ($this->logged_user->can('manage_users')) {
            return view('admin.users');
        }

        return redirect($this->redirect);
    }

    public function getContents($status)
    {
        if ($this->logged_user->can('manage_content')) {
            $statuses['deleted'] = view('admin.contents_deleted');
            $statuses['pending'] = view('admin.contents_pending');
            $statuses['published'] = view('admin.contents_published');
            $statuses['private'] = view('admin.contents_private');
            $statuses['app'] = view('admin.contents_app');

            return isset($statuses[$status]) ? $statuses[$status] : view('admin.contents');
        }

        return redirect($this->redirect);
    }

    public function getContentSettings($id)
    {
        if ($this->logged_user->can('manage_content')) {
            $content = Content::withTrashed()->findOrFail($id);

            $data = upload_content_default_data();
            $data['languages'] = Language::all();
            $data['content'] = $content;
            $data['upload_type'] = $data['content']->type;
            $data['plates'] = $content->plates;
            $data['categories'] = $content->categories->toArray();

            if (count($data['plates']) && is_null(old('licenses'))) {
                foreach ($data['plates'] as $key => $plate) {
                    if (!is_null($plate->info)) {
                        $data['licenses'][$key]['name'] = $plate->info->name;
                        $data['licenses'][$key]['country_code'] = $plate->info->country_code;
                        $data['licenses'][$key]['region_code'] = $plate->info->region_code;
                        $data['licenses'][$key]['type_id'] = $plate->info->type_id;
                        $data['licenses'][$key]['make_id'] = $plate->info->make_id;
                        $data['licenses'][$key]['model_id'] = $plate->info->model_id;
                        $data['licenses'][$key]['color_id'] = $plate->info->color_id;
                    }
                }
            }

            JavaScript::put([
                'content_id' => $id,
                'dropzone_upload_text' => trans('video.dropbox_upload_text'),
                'dropzone_remove_video' => trans('video.dropzone_remove_video'),
                'dropzone_remove_photo' => trans('video.dropzone_remove_photo'),
                'dropzone_max_files_exceeded' => trans('video.dropzone_max_files_exceeded'),
                'photos' => $content->images->transform(function ($item, $key) use($content) {
                    $item['url'] = $item->url($content->original_filename, 'medium');
                    $item['size'] = $item->size($content->original_filename);
                    return $item;
                }),
                'thumbnail' => [
                    ['url' => $content->thumbnail_url],
                ],
                'settings' => [
                    'map_element_id' => 'map',
                    'latitude' => $content->latitude,
                    'longitude' => $content->longitude,
                    'address' => $content->address,
                    'zoom' => 14,
                    'default_marker' => true,
                    'map_marker_draggable' => true,
                    'map_marker_title' => trans('app.drag_me'),
                    'map_icon' => $content->first_category_icon_url,
                    'map_marker_events' => ['dragend'],
                    'map_no_geometry' => trans('app.map_no_geometry'),
                    'map_search' => true,
                    'map_search_box_placeholder' => trans('video.search_google_maps'),
                    'prev_map' => false
                ]
            ]);

            $data['flowplayer_settings'] = $content->flowplayer_settings;

            return view('admin.content_settings', $data);
        }

        return redirect($this->redirect);
    }

    public function postDeleteContent(Request $request)
    { 
        if ($this->logged_user->can('manage_content')) {
            if (is_array($request->id)) {
                foreach ($request->id as $id) {
                    $content = Content::find($id);
                    if ($content) {
                        $content->deleteInactiveEmbed();
                        $content->delete();
                    }
                }
            } else {
                $content = Content::findOrFail($request->id);
                $content->deleteInactiveEmbed();
                $content->delete();
            }

            return [
                'success_title' => 'Success',
                'success_body' => 'Content was successfully deleted'
            ];
        }

        return $this->unauthorized();
    }

    public function postRestoreContent(Request $request)
    {
        if ($this->logged_user->can('manage_content')) {
            if (is_array($request->id)) {
                foreach ($request->id as $id) {
                    $content = Content::onlyTrashed()->find($id);
                    if ($content) {
                        $content->restore(); 
                    }
                }
            } else {
                $content = Content::onlyTrashed()->findOrFail($request->id);
                $content->restore(); 
            }

            return [
                'success_title' => 'Success',
                'success_body' => 'Content was successfully restored'
            ];
        }

        return $this->unauthorized();
    }

    public function postPublishContent(Request $request)
    {
        if ($this->logged_user->can('manage_content')) {
            $content = Content::findOrFail($request->id);
            $content->publish();

            return [
                'success_title' => 'Success',
                'success_body' => 'Content was successfully published'
            ];
        }

        return $this->unauthorized();
    }

    public function postSetContentAsPending(Request $request)
    {
        if ($this->logged_user->can('manage_content')) {
            $content = Content::findOrFail($request->id);
            $content->setAsPending();

            return [
                'success_title' => 'Success',
                'success_body' => 'Content was successfully set to pending'
            ];
        }

        return $this->unauthorized();
    }

    public function postForceDeleteContent(Request $request)
    {
        if ($this->logged_user->can('manage_content')) {
            if (is_array($request->id)) {
                foreach ($request->id as $id) {
                    $content = Content::onlyTrashed()->find($id);
                    if ($content) {
                        $content->deleteLocalFiles();
                        $content->deleteRemoteFiles();
                        $content->deleteInactiveEmbed();
                        $content->forceDelete(); 
                    }
                }
            } else {
                $content = Content::onlyTrashed()->findOrFail($request->id);
                $content->deleteLocalFiles();
                $content->deleteRemoteFiles();
                $content->deleteInactiveEmbed();
                $content->forceDelete(); 
            }                      

            return [
                'success_title' => 'Success',
                'success_body' => 'Content was successfully deleted permanently'
            ];
        }

        return $this->unauthorized();
    }

    public function postDeleteUser(Request $request)
    {
        if ($this->logged_user->can('manage_users')) {
            $user = User::findOrFail($request->id);

            $user->delete();

            return [
                'success_title' => 'Success',
                'success_body' => 'User successfully deleted'
            ];
        }

        return $this->unauthorized();
    }

    public function postRestoreUser(Request $request)
    {
        if ($this->logged_user->can('manage_users')) {
            $user = User::onlyTrashed()->findOrFail($request->id);

            $user->restore();

            return [
                'success_title' => 'Success',
                'success_body' => 'User successfully restored'
            ];
        }

        return $this->unauthorized();
    }

    public function getUserSettings(Request $request, $id)
    {
        if ($this->logged_user->can('manage_users')) {
            $data['subject'] = User::withTrashed()->findOrFail($id);
            $data['roles'] = Role::whereNotIn('name', ['super_admin'])->get();

            return view('admin.user_settings', $data);            
        }

        return redirect($this->redirect);
    }

    public function postEditUserRole(Request $request)
    {
        if ($this->logged_user->can('manage_users')) {
            $user = User::withTrashed()->findOrFail($request->user_id);
            $role = Role::whereNotIn('name', ['super_admin'])->whereId($request->role_id)->firstOrFail();
            $remove = filter_var($request->remove, FILTER_VALIDATE_BOOLEAN);

            if ($remove) {
                $user->removeRole($role->id);
            } else {
                $user->assignRole($role->name);
            }

            return [
                'success_title' => 'Success',
                'success_body' => 'Changes saved successfully',
            ];
        }

        return $this->unauthorized();
    }

    public function postEditRolePermission(Request $request)
    {
        if ($this->logged_user->can('manage_users')) {
            $role = Role::whereNotIn('name', ['super_admin'])->whereId($request->role_id)->firstOrFail();
            $permission = Permission::findOrFail($request->permission_id);
            $remove = filter_var($request->remove, FILTER_VALIDATE_BOOLEAN);

            if ($remove) {
                $role->removePermission($permission->id);
            } else {
                $role->givePermissionTo($permission->name);
            }

            return [
                'success_title' => 'Success',
                'success_body' => 'Changes saved successfully',
            ];
        }

        return $this->unauthorized();
    }

    public function getRolesPermissions()
    {
        if ($this->logged_user->can('manage_users')) {
            $data['roles'] = Role::whereNotIn('name', ['super_admin'])->get();
            $data['permissions'] = Permission::all();

            return view('admin.roles_permissions', $data);
        }

        return redirect($this->redirect);
    }

    public function postEditContent(AdminEditContentRequest $request)
    {
        $user = $request->user();
        $content = Content::withTrashed()->findOrFail($request->id);        

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
        $content->updateTranslations($request->all());
        $content->deleteInactiveEmbed();        

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
        
        foreach ($request->licenses as $key => $plate) {
            if (!empty($plate['name'])) {
                $processed_plate = $license_plate->process($plate);
                $content->addPlate(['license_id' => $processed_plate->id]);
            }
        }

        session()->forget('video_filename');
        session()->forget('photo_filename');

        return [
            'success_title' => 'Success',
            'success_body' => 'Your changes has been saved successfully'
        ];
    }

    public function getComments()
    {
        if ($this->logged_user->can('manage_comments')) {
            return view('admin.comments');
        }

        return redirect($this->redirect);
    }

    public function postEditComment(Request $request)
    {
        if ($this->logged_user->can('manage_comments')) {
            $comment = $request->type == 'comment' ? Comment::findOrFail($request->id) : CommentReply::findOrFail($request->id);
            $comment->body = $request->body;
            $comment->save();

            return [
                'success_title' => 'Success',
                'success_body' => 'Your changes has been saved successfully'
            ];
        }

        return $this->unauthorized();
    }

    public function postForceDeleteComment(Request $request)
    {
        if ($this->logged_user->can('manage_comments')) {
            $comment = $request->type == 'comment' ? Comment::findOrFail($request->id) : CommentReply::findOrFail($request->id);
            $comment->forceDelete();

            return [
                'success_title' => 'Success',
                'success_body' => 'Comment was successfully deleted'
            ];
        }

        return $this->unauthorized();
    }

    public function getTranslators()
    {
        if ($this->logged_user->can('manage_translators')) {
            $data['languages'] = Language::all();
            $data['countries'] = Country::all();

            return view('admin.translators', $data);
        }

        return redirect($this->redirect);
    }

    public function postDeleteTranslator(Request $request)
    {
        if ($this->logged_user->can('manage_translators')) {
            $user = User::findOrFail($request->id);
            $user->removeRole(3);
            
            return [
                'success_title' => 'Success',
                'success_body' => 'User was successfully removed as a translator'
            ];   
        }

        return $this->unauthorized();
    }

    public function postAssignLanguage(Request $request)
    {
        if (is_null($request->languages)) {
            return response(['message' => 'Please select a language'], 422);
        }

        if ($this->logged_user->can('manage_translators')) {
            $user = User::findOrFail($request->id);
            $user->languages()->detach();

            foreach ($request->languages as $language) {
                $user->assignLanguage($language);
            }

            return [
                'success_title' => 'Success',
                'success_body' => 'Language assigned successfully'
            ];
        }

        return $this->unauthorized();
    }

    public function postAddTranslator(Request $request, UserMailer $mailer)
    {
        if ($this->logged_user->can('manage_translators')) {
            $this->validate($request, [
                'username' => 'required|alpha_dash|unique:users,username',
                'email' => 'required|unique:users,email',
                'languages' => 'required'
            ]);

            $password = str_random(8);

            $request->merge([
                'password' => $password
            ]);            

            $user = User::create($request->all());
            $user->assignRole('translator');
            $user->assignLanguages($request->languages);

            $mailer->sendTranslatorPassword($user, $password);

            return [
                'success_title' => 'Success',
                'success_body' => 'New translator was added successfully. Password was sent to '.$user->email
            ];
        }

        return $this->unauthorized();
    }

    public function getLocalization(Request $request, LanguageRepository $lang, $locale)
    {
        if ($this->logged_user->canTranslate($locale)) {
            
            $data['lang'] = $lang->findByLocale($locale);

            if (!is_null($data['lang'])) {
                return view('admin.localization', $data);
            }            
        }

        return redirect($this->redirect);
    }

    public function postUpdateTranslation(Request $request, TranslationRepository $trans)
    {
        $lang = $trans->find($request->id);

        if ($this->logged_user->canTranslate($request->locale) && !is_null($lang)) {
            if ($request->locale == $lang->locale) {
                $trans->updateAndLock($request->id, $request->text);
            } else {
                $trans->create([
                    'locale' => $request->locale,
                    'namespace' => $lang->namespace,
                    'group' => $lang->group,
                    'item' => $lang->item,
                    'text' => $request->text
                ]);
            }

            return [
                'success_title' => 'Success',
                'success_body' => 'Translation successfully updated'
            ];
        }

        return $this->unauthorized();
    }

    public function postAddTranslationItem(Request $request, TranslationRepository $trans)
    {
        if ($this->logged_user->can('manage_translations')) {
            $this->validate($request, [
                'locale' => 'required|exists:translator_languages',
                'group' => 'required',
                'item' => 'required',
                'text' => 'required'
            ]);

            $request->merge(['namespace' => '*']);

            $trans->create($request->all());

            return [
                'success_title' => 'Success',
                'success_body' => 'Translation item added successfully'
            ];
        }

        return $this->unauthorized();
    }

    public function postUpdateContentTranslation(Request $request)
    {
        if ($this->logged_user->canTranslate($request->locale)) {
            $this->validate($request, [
                'id' => 'required|exists:contents',
                'locale' => 'required|exists:translator_languages'
            ]);

            $content = Content::findOrFail($request->id);
            $content->updateTranslations($request->all());

            return [
                'success_title' => 'Success',
                'success_body' => 'Translation successfully updated'
            ];
        }

        return $this->unauthorized();
    }

    public function getLanguages()
    {
        if ($this->logged_user->can('manage_languages')) {

            return view('admin.languages');
        }

        return redirect($this->redirect);
    }

    public function postEditLanguage(Request $request, LanguageRepository $lang)
    {
        if ($this->logged_user->can('manage_languages')) {
            $this->validate($request, [
                'id' => 'required|exists:translator_languages',
                'locale' => 'required|alpha_dash|max:6',
                'name' => 'required',
                'country_code' => 'required',
                'url' => 'required',
            ]);

            $lang->update($request->all());

            return [
                'success_title' => 'Success',
                'success_body' => 'Language updated successfully'
            ];
        }

        return $this->unauthorized();
    }

    public function postDeleteLanguage(Request $request, LanguageRepository $lang)
    {
        if ($this->logged_user->can('manage_languages')) {
            $lang->delete($request->id);

            return [
                'success_title' => 'Success',
                'success_body' => 'Language was successfully deleted'
            ];
        }

        return $this->unauthorized();
    }

    public function postForceDeleteLanguage(Request $request)
    {
        if ($this->logged_user->can('manage_languages')) {
            $lang = Language::withTrashed()->findOrFail($request->id);

            $lang->forceDelete();

            return [
                'success_title' => 'Success',
                'success_body' => 'Language was successfully deleted permanently'
            ];
        }

        return $this->unauthorized();
    }

    public function postRestoreLanguage(Request $request, LanguageRepository $lang)
    {
        if ($this->logged_user->can('manage_languages')) {
            $lang->restore($request->id);
            
            return [
                'success_title' => 'Success',
                'success_body' => 'Language was successfully restored'
            ];
        }

        return $this->unauthorized();
    }

    public function postAddLanguage(Request $request)
    {
        if ($this->logged_user->can('manage_languages')) {
            $this->validate($request, [
                'locale' => 'required|alpha_dash|max:6|unique:translator_languages',
                'name' => 'required|unique:translator_languages',
                'country_code' => 'required',
                'url' => 'required',
            ]);

            Language::create($request->all());

            return [
                'success_title' => 'Success',
                'success_body' => 'Language was added successfully'
            ];
        }

        return $this->unauthorized();
    }

    public function getSuggestedLocations()
    {
        if ($this->logged_user->can('manage_suggested_locations')) {

            return view('admin.suggested_locations');
        }

        return redirect($this->redirect);
    }

    public function postApproveSuggestedLocation(Request $request)
    {
        if ($this->logged_user->can('manage_suggested_locations')) {
            $location = SuggestedLocation::findOrFail($request->id);
            $content = $location->content;

            if ($location->country_code) $content->country_code = $location->country_code;
            if ($location->region_code) $content->region_code = $location->region_code;
            if ($location->city_name) $content->city_name = $location->city_name;
            if ($location->latitude) $content->latitude = $location->latitude;
            if ($location->longitude) $content->longitude = $location->longitude;

            $content->save();

            $location->status = 'Approved';
            $location->save();
            $location->delete();
            
            return [
                'success_title' => 'Success',
                'success_body' => 'Suggested location was successfully approved'
            ];
        }

        return $this->unauthorized();
    }

    public function postDeleteSuggestedLocation(Request $request)
    {
        if ($this->logged_user->can('manage_suggested_locations')) {
            $location = SuggestedLocation::findOrFail($request->id);
            $location->delete();

            return [
                'success_title' => 'Success',
                'success_body' => 'Suggested location was successfully deleted'
            ];
        }

        return $this->unauthorized();
    }

    public function getMultipleViolations()
    {
        if ($this->logged_user->can('manage_content')) {
            return view('admin.contents_multiple_violations');
        }

        return redirect($this->redirect);
    }

    public function getInactiveEmbed()
    {
        if ($this->logged_user->can('manage_content')) {

            return view('admin.inactive_embed');
        }

        return redirect($this->redirect);
    }

    public function getAds()
    {
        if ($this->logged_user->can('manage_ads')) {
            return view('admin.ads');
        }

        return redirect($this->redirect);
    }

    public function postAddAd(Request $request)
    {
        if ($this->logged_user->can('manage_ads')) {
            $this->validate($request, [
                'label' => 'required',
                'code' => 'required'
            ]);

            Ad::create($request->all());

            return [
                'success_title' => 'Success',
                'success_body' => 'Ad code was added successfully'
            ];
        }

        return $this->unauthorized();
    }

    public function postEditAd(Request $request)
    {
        if ($this->logged_user->can('manage_ads')) {
            $this->validate($request, [
                'id' => 'required|exists:ads',
                'label' => 'required',
                'code' => 'required'
            ]);

            $ad = Ad::findOrFail($request->id);
            $ad->update($request->all());

            return [
                'success_title' => 'Success',
                'success_body' => 'Changes was successfully saved'
            ];
        }

        return $this->unauthorized();
    }

    public function postDeleteAd(Request $request)
    {
        if ($this->logged_user->can('manage_ads')) {
            $ad = Ad::findOrFail($request->id);

            $ad->delete();

            return [
                'success_title' => 'Success',
                'success_body' => 'Ad was successfully deleted'
            ];
        }

        return $this->unauthorized();
    }

    public function postForceDeleteAd(Request $request)
    {
        if ($this->logged_user->can('manage_ads')) {
            $ad = Ad::onlyTrashed()->findOrFail($request->id);

            $ad->forceDelete();

            return [
                'success_title' => 'Success',
                'success_body' => 'Ad was successfully permanently deleted'
            ];
        }

        return $this->unauthorized();
    }

    public function postRestoreAd(Request $request)
    {
        if ($this->logged_user->can('manage_ads')) {
            $ad = Ad::onlyTrashed()->findOrFail($request->id);

            $ad->restore();

            return [
                'success_title' => 'Success',
                'success_body' => 'Ad was successfully restored'
            ];
        }

        return $this->unauthorized();
    }

    public function getUnencodedContents()
    {
        return view('admin.unencoded_contents');
    }

    public function postEncodeContent(Request $request)
    {
        $content = Content::whereId($request->id)
                    ->whereType('video')
                    ->whereNull('embed_type')
                    ->firstOrFail();

        if ($content) {
            //$this->dispatch(new EncodeVideo($content, 'ffmpeg'));
            $content->encode('ffmpeg', true);
            //$content->gstreamerEncode();
            return [
                'success_title' => 'Success',
                'success_body' => 'Video was successfully encoded'
            ];            
        }        
    }

    public function getImpersonate($id)
    {
        if ($this->logged_user->can('impersonate')) {
            $user = User::findOrFail($id);

            Auth::login($user);

            session(['impersonating' => true]);
            session(['impersonator_id' => $this->logged_user->id]);

            return redirect($user->url);
        }

        return redirect($this->redirect);
    }

    public function postChangeUserPassword(Request $request)
    {
        if ($this->logged_user->can('manage_users')) {
            $this->validate($request, [
                'password' => 'required'
            ]);

            $user = User::findOrFail($request->id);

            $user->changePassword($request->password);

            return [
                'success_title' => 'Success',
                'success_body' => 'New user password was successfully saved',
            ];
        }

        return $this->unauthorized();
    }

    public function postEditUserProfile(Request $request)
    {
        if ($this->logged_user->can('manage_users')) {
            $this->validate($request, [
                'username' => 'required|alpha_dash|unique:users,username,'.$request->id,
                'email' => 'required|email|unique:users,email,'.$request->id,
                'country_code' => 'required|exists:countries,code',
                'birth_day' => 'date',
            ]);

            $user = User::findOrFail($request->id);
            $user->update($request->all());
            $user->updateSlug($request->username);

            return [
                'success_title' => 'Success',
                'success_body' => 'User profile was successfully updated'
            ];
        }

        return $this->unauthorized();
    }

    public function getPages()
    {
        return view('admin.pages');
    }

    public function getFlushCache()
    {
        Artisan::queue('mapcontentjson:generate', ['locale' => 'www']);
        Artisan::queue('mapcontentjson:generate', ['locale' => 'en']);
        Artisan::queue('mapcontentjson:generate', ['locale' => 'il']);
        Artisan::queue('mapcontentjson:generate', ['locale' => 'ar']);
        Artisan::queue('mapcontentjson:generate', ['locale' => 'ru']);
        Artisan::queue('mapcontentjson:generate', ['locale' => 'ro']);

        Cache::tags(['trending_contents', 'main_contents', 'smils', 'players'])->flush();

        return redirect()->back()->withSucces('Cache has been successfully flushed.');
    }

    public function postAddTranslatorFilters(Request $request)
    {
        if ($this->logged_user->can('manage_translators')) {
            $translator = User::findOrFail($request->id);
            $translator->translatorExcludedCountries()->delete();

            $translator->addTranslatorExcludedCountries($request->country_codes);

            return [
                'success_title' => 'Success',
                'success_body' => 'Translator filters was successfully saved.'
            ];
        }

        return $this->unauthorized();
    }

    public function getReportedContents()
    {
        if ($this->logged_user->can('manage_content')) {
            return view('admin.reported_contents');
        }

        return redirect($this->redirect);
    }

    public function postDeleteContentReport(Request $request)
    {
        if ($this->logged_user->can('manage_content')) {
            $report = ReportedContent::findOrFail($request->id);
            $report->delete();

            return [
                'success_title' => 'Success',
                'success_body' => 'Reports was successfully deleted'
            ];
        }

        return $this->unauthorized();
    }

    public function getNonIsraelVideos()
    {
        $contents = Content::whereType('video')
                    ->whereNull('embed_type')
                    ->where('country_code', '!=', 'IL')
                    ->where('original_filename', '!=', '')
                    ->whereApproved(1)
                    ->whereEnabled(1)
                    ->get()
                    ->pluck(['original_filename']);

        dd($contents);
    }

    public function getAddLiveFeed()
    {
        $data['feed'] = new LiveFeed;
        $data['action_url'] = route('admin::postAddLiveFeed');
        $data['submit_button_text'] = 'Submit';
        $data['submit_button_loading_text'] = 'Submitting...';

        $user_geo = user_geo();

        JavaScript::put([            
            'settings' => [
                'map_element_id' => 'map',
                'lat' => $user_geo['latitude'],
                'lng' => $user_geo['longitude'],
                'zoom' => 14,
                'default_marker' => true,
                'map_marker_draggable' => true,
                'map_marker_title' => trans('app.drag_me'),
                'map_icon' => asset("images/categories/icon_44.png"),
                'map_marker_events' => ['dragend'],
                'map_no_geometry' => trans('app.map_no_geometry'),
                'map_search' => true,
                'map_search_box_placeholder' => trans('video.search_google_maps')
            ]
        ]);

        return view('admin.add_live_feed', $data);
    }

    public function postAddLiveFeed(Request $request)
    {
        $this->validate($request, [
            'title' => 'required',
            'content_url' => 'required',
            'type' => 'required|in:video,photo,embed,stream',
            'thumb_url' => 'required',
            'country_code' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);
//dd($request->all());
        LiveFeed::create($request->all());

        return [
            'success_title' => 'Success',
            'success_body' => 'Live feed was successfully added.',
            'redirect' => route('admin::getLiveFeeds')
        ];
    }

    public function getLiveFeeds()
    {
        return view('admin.live_feeds');
    }

    public function getEditLiveFeed($id)
    {
        $data['feed'] = LiveFeed::find($id);

        if (is_null($data['feed'])) {
            return redirect()->route('admin::getLiveFeeds');
        }

        $data['action_url'] = route('admin::postUpdateLiveFeed');
        $data['submit_button_text'] = 'Save';
        $data['submit_button_loading_text'] = 'Saving...';

        JavaScript::put([            
            'settings' => [
                'map_element_id' => 'map',
                'lat' => $data['feed']->latitude,
                'lng' => $data['feed']->longitude,
                'zoom' => 14,
                'default_marker' => true,
                'map_marker_draggable' => true,
                'map_marker_title' => trans('app.drag_me'),
                'map_icon' => asset("images/categories/icon_44.png"),
                'map_marker_events' => ['dragend'],
                'map_no_geometry' => trans('app.map_no_geometry'),
                'map_search' => true,
                'map_search_box_placeholder' => trans('video.search_google_maps')
            ]
        ]);

        return view('admin.edit_live_feed', $data);
    }

    public function postUpdateLiveFeed(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|exists:live_feeds,id',
            'title' => 'required',
            'content_url' => 'required',
            'type' => 'required|in:video,photo,embed,stream',
            'thumb_url' => 'required',
            'country_code' => 'required',
            'latitude' => 'required',
            'longitude' => 'required'
        ]);

        $feed = LiveFeed::find($request->id);

        $request->merge([
            'embed' => is_null($request->embed) ? 0 : 1
        ]);

        $feed->update($request->all());

        return [
            'success_title' => 'Success',
            'success_body' => 'Live feed was successfully updated.'            
        ];
    }

    public function postDeleteLiveFeed(Request $request)
    {
        $feed = LiveFeed::findOrFail($request->id);
        $feed->delete();

        return [
            'success_title' => 'Success',
            'success_body' => 'Live feed was successfully deleted.',
            'redirect' => 'self'
        ];
    }
}
