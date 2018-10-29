<?php

namespace App\Http\Controllers;

use JavaScript;
use App\Content;
use Aws\S3\S3Client;
use App\LicensePlate;
use App\Http\Requests;
use App\Services\Tinify;
use Illuminate\Http\Request;
use App\Uploaders\PhotoUploader;
use App\Uploaders\VideoUploader;
use App\Uploaders\AvatarUploader;
use App\Http\Controllers\Controller;
use Illuminate\Filesystem\Filesystem;
use App\Http\Requests\PostContentRequest;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Intervention\Image\Facades\Image as InterventionImage;

class UploadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function getVideo()
    {
        $data = upload_content_default_data();
        $data['upload_type'] = 'video';
        $data['upload_translated_type'] = strtolower(trans('video.video'));

        $user_geo = user_geo();

        JavaScript::put([
            'dropzone_upload_text' => trans('video.dropbox_upload_text'),
            'dropzone_remove_video' => trans('video.dropzone_remove_video'),
            'settings' => [
                'map_element_id' => 'map',
                'lat' => $user_geo['latitude'],
                'lng' => $user_geo['longitude'],
                'zoom' => 14,
                'default_marker' => true,
                'map_marker_draggable' => true,
                'map_marker_title' => trans('app.drag_me'),
                'map_icon' => asset("images/categories/icon_8.png"),
                'map_marker_events' => ['dragend'],
                'map_no_geometry' => trans('app.map_no_geometry'),
                'map_search' => true,
                'map_search_box_placeholder' => trans('video.search_google_maps')
            ]
        ]);

        return view('upload_video', $data);
    }

    public function getPhoto()
    {
        $data = upload_content_default_data();
        $data['upload_type'] = 'photo';
        $data['upload_translated_type'] = strtolower(trans('video.photo'));
        
        if (session()->has('photos')) {
            foreach (session('photos') as $key => $filename) {
                delete_dir(config('app.gallery_path') . remove_extension($filename));    
            }

            session()->forget('photos');
        }        

        $user_geo = user_geo();
        
        JavaScript::put([
            'dropzone_upload_text' => trans('video.dropbox_upload_text'),
            'dropzone_remove_photo' => trans('video.dropzone_remove_photo'),
            'dropzone_max_files_exceeded' => trans('video.dropzone_max_files_exceeded'),
            'settings' => [
                'map_element_id' => 'map',
                'lat' => $user_geo['latitude'],
                'lng' => $user_geo['longitude'],
                'zoom' => 14,
                'default_marker' => true,
                'map_marker_draggable' => true,
                'map_marker_title' => trans('app.drag_me'),
                'map_icon' => asset("images/categories/icon_8.png"),
                'map_marker_events' => ['dragend'],
                'map_no_geometry' => trans('app.map_no_geometry'),
                'map_search' => true,
                'map_search_box_placeholder' => trans('video.search_google_maps')
            ]
        ]);

        return view('upload_photo', $data);
    }    

    public function postUploadVideo(Request $request, VideoUploader $uploader)
    {

        $this->validate($request, [
            'video' => 'required|mimes:flv,wmv,asf,avi,mov,mp4,3gp,m4v,mpeg,mpg,m4v,f4v,qt|max:512000',
        ]);

        $content = $uploader->upload($request->file('video'));

        session(['video_filename' => $content->getFilename()]);

        return ['url' => $content->url()];
    }

    public function postUploadPhoto(Request $request, PhotoUploader $uploader)
    {
        $this->validate($request, [
            'photo' => 'required|image|max:20000',
        ]);

        $content = $uploader->upload($request->file('photo'))->resize();
        $filename = $content->getFilename();        

        if (session()->has('photos')) {
            session()->push('photos', $filename);
        } else {
            session(['photos' => [$filename]]);
        }

        return [
            'filename' => $filename,
            'url' => $content->url()
        ];
    }

    public function postChangeThumbnail(Request $request, PhotoUploader $uploader)
    {
        $this->validate($request, [
            'id' => 'required',
            'photo' => 'required|image|max:20000'
        ]);

        $user = $request->user();

        if ($user->hasRole('super_admin')) {
            $video = Content::findOrFail($request->id);
        } else {
            $video = $request->user()->videos()->whereId($request->id)->firstOrFail();
        }

        $photo = $request->file('photo');
        $originalPathFile = null;
        $originalPathFileWatermark = null;
        $embedded = is_null($video->embed_id) ? false : true;

        if ($video->type == 'video') {
            $subDir = $video->sub_dir;
            $filename = sha1(time() . $photo->getClientOriginalName()) . '.jpg';
            $versions = $video->versions;
            $keys = array_keys($versions);
            $lastVersionKey = end($keys);

            $client = s3Client();                            

            foreach ($versions as $key => $version) {
                $localPath = public_path($version['thumb_path'] . $subDir . $video->original_filename . '/');
                $remotePathFile = $version['remote_thumb_path'] . $subDir . $video->original_filename . '/' . $filename;                
                $watermark = public_path($version['watermarks_path'] . '60.png');

                if ($embedded) {
                    $localPath = public_path($version['thumb_path'] . $subDir . 'embedded/');
                    $remotePathFile = $version['remote_thumb_path'] . $subDir . 'embedded/' . $filename;
                }

                $localPathFile = $localPath . $filename;

                make_dir($localPath);
                
                if ($key == 0) {
                    $originalPathFile = $localPathFile;
                    $originalRemotePathFile = $remotePathFile;
                    $originalPathFileWatermark = $watermark;
                    $this->upload($photo, $localPath, $filename);
                } else {                   
                    copy($originalPathFile, $localPathFile);
                    $this->addWatermark($localPathFile, $watermark);
                    s3Sync($client, $localPathFile, $remotePathFile);
                }

                if ($lastVersionKey == $key) {
                    $this->addWatermark($originalPathFile, $originalPathFileWatermark);
                    s3Sync($client, $originalPathFile, $originalRemotePathFile);
                }
            }

            $video->thumbnail = $filename;
            $video->save();
        }        
    }

    protected function addWatermark($target, $watermark)
    {
        $cmd = "composite -gravity northwest -geometry +10+10 -dissolve 100% " . $watermark . " " . $target . " " . $target;
        shell_exec($cmd);
    }   

    protected function upload(UploadedFile $file, $localPath, $filename)
    {
        $file = $file->move($localPath, $filename);

        $localFilePath = $localPath . $filename;       

        InterventionImage::make($localFilePath)
            ->resize(900, 900, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save($localFilePath);

        return $file;
    }      

    public function postContent(PostContentRequest $request, Tinify $tinify)
    {
        $user = $request->user();
        $original_filename = $request->type == 'video' ? session('video_filename') : null;

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
            'original_filename' => $original_filename,
            'ip' => $request->ip(),
            'embed_id' => $embed_id,
            'embed_type' => $embed_type,
            'disable_comments' => $request->disable_comments,
            'private' => $request->private,
            'disable_map' => $request->disable_map,
            'offence_date' => $request->offence_date.' '.$request->offence_time,
        ]);

        $content = $user->addContent($request->all());

        if ($user->hasRole('user_autoapprove')) {
            $content->approve();
        }

        if ($request->type == 'photo') {
            $content->addImages(session()->pull('photos'));
        }

        if (!is_null($request->categories)) {
            foreach ($request->categories as $key => $category_id) {
                $content->addCategory(['niche_id' => $category_id]);                
            }
        } else {
            $content->addCategory(['niche_id' => 8]);
        }

        $license_plate = new LicensePlate;
        
        foreach ($request->licenses as $key => $plate) {
            if (!empty($plate['name'])) {
                $processed_plate = $license_plate->process($plate);
                $content->addPlate(['license_id' => $processed_plate->id]);
            }
        }

        session()->forget('video_filename');        

        return [
            'immediate_redirect' => true,
            'redirect' => $user->username == 'admin' ? $content->url : $content->thank_you_url
        ];
    }

    public function postUpdateAvatar(Request $request, AvatarUploader $uploader)
    {
        $this->validate($request, [
            'avatar' => 'required|image|max:20000'
        ]);

        $avatar = $uploader->upload($request->file('avatar'))->resize();
        $filename = $avatar->getFilename();

        $user = $request->user();
        $user->updateAvatar($filename);

        return [
            'avatar_url' => $user->medium_avatar
        ];
    }

    public function getThankYou(Request $request, $id)
    {
        $user = $request->user();

        $data['content'] = $user->contents()->whereId($id)->first();

        if (is_null($data['content'])) {
            return redirect()->route('home');
        }

        return view('upload_thank_you', $data);
    }
}
