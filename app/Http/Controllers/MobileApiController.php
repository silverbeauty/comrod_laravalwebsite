<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use App\LicensePlate;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Uploaders\PhotoUploader;
use App\Uploaders\VideoUploader;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class MobileApiController extends Controller
{
    protected $data;

    public function __construct(Request $request)
    {
        //dd(urlencode(encrypt_data('key=wzsm9XrRWq3caJoQMSHSrvAllfQ7lzao4R97LWP6lIq2912tjHili3MLPHpZ')));
        $this->middleware('api');                
    }

    protected function failed(array $response = [])
    {
        return ['success' => false, 'response' => $response];
    }

    protected function success(array $response)
    {
        return ['success' => true, 'response' => $response];
    }

    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        if (isset($username) && isset($password)) {
            if (Auth::attempt(['username' => $username, 'password' => $password])) {
                $user = Auth::user();

                return $this->success([
                    'user_id' => $user->id
                ]);
            } else {
                $old_user = User::whereUsername($username)->whereRaw('password = MD5(CONCAT("'.$password.'",salt))')->first();

                if ($old_user) {
                    return $this->success([
                        'user_id' => $old_user->id
                    ]);
                }
            }
        }

        return $this->failed(['message' => 'user not exist']);
    }

    public function socialLogin(Request $request)
    {
        $user = User::whereEmail($request->email)->first();

        if (!$user) {
            return $this->failed(['message' => 'No results found']);
        }

        return $this->success(['user_id' => $user->id]);
    }

    public function socialSignup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'email' => 'unique:users',
            'provider' => 'required',
            'social_id' => 'required',            
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors()->all());
        }

        $ip = $request->ip();

        $attributes = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            $request->provider . '_id' => $request->social_id,
            'avatar_social' => $request->avatar_url,
            'registration_ip' => $ip,
            'last_ip' => $ip,
            'last_login' => Carbon::now(),
            'last_last_login' => Carbon::now(),
            'user_agent' => $request->os
        ];

        $user = User::create($attributes);

        return $this->success([
            'user_id' => $user->id
        ]);
    }

    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|unique:users',
            'email' => 'unique:users',
            'password' => 'required',
            'country_code' => 'exists:countries,code'
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors()->all());
        }

        $ip = $request->ip();

        $attributes = [
            'username' => $request->username,
            'password' => $request->password,
            'email' => $request->email,
            'country_code' => $request->country_code,
            'registration_ip' => $ip,
            'last_ip' => $ip,
            'last_login' => Carbon::now(),
            'last_last_login' => Carbon::now(),
            'user_agent' => $request->os
        ];

        $user = User::create($attributes);

        return $this->success([
            'user_id' => $user->id
        ]);
    }

    public function account(Request $request)
    {
        $user = User::find($request->user_id);

        if (!$user) {
            return $this->failed(['message' => 'No results found']);
        }

        $contents = map_info(
                        $user->contents($request->user_id)
                        ->with(['images.content', 'country', 'categories.category'])
                        ->latest()
                        ->withLatLng()
                        ->get()
                    );

        return $this->success([
            'username' => $user->username,
            'location' => $user->country_code,
            'name' => $user->name,
            'age' => $user->age,
            'content_count' => $user->total_contents,
            'contents' => $contents
        ]);   
    }

    public function searchByPlate(Request $request)
    {
        $plate = LicensePlate::whereName($request->plate)->first();

        if (!$plate || !count($plate->contents)) {
            return $this->failed(['message' => 'No result found']);
        }

        $contents = [];

        foreach ($plate->contents as $key => $content) {
            $contents[$key]['id'] = $content->id;
            $contents[$key]['title'] = $content->title;
            $contents[$key]['description'] = $content->description;
            $contents[$key]['url'] = $content->url;
            $contents[$key]['thumb_url'] = $content->thumbnail_url;
            $contents[$key]['type'] = $content->type;
        }

        return $this->success($contents);
    }

    public function uploadVideo(Request $request, VideoUploader $uploader)
    {
        $content = $uploader->upload($request->file('video'));

        return $this->success([
            'filename' => $content->getFilename()
        ]);
    }

    public function uploadPhoto(Request $request, PhotoUploader $uploader)
    {
        $content = $uploader->upload($request->file('photo'));

        return $this->success([
            'filename' => $content->getFilename()
        ]);
    }

    public function uploadContent(Request $request)
    {
        $user = User::find($request->user_id);

        if (is_null($user)) {
            return $this->failed(['message' => 'Invalid user']);
        }        

        $validator = Validator::make($request->all(), [
            'original_filename' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'date' => 'required',
            'time' => 'required',
            'type' => 'required',
            'country_code' => 'required'          
        ]);

        if ($validator->fails()) {
            return $this->failed($validator->errors()->all());
        }

        $original_filename = $request->type == 'video' ? $request->original_filename : null;
        $offence_date = $request->date.' '.$request->time;
        $title = $request->title ?: $user->username . ' ' . $offence_date;

        $attributes = [
            'title' => $title,
            //'description' => $request->description ?: $title,
            'slug' => str_slug($title),
            'original_filename' => $original_filename,
            'start_in_seconds' => $request->start_in_seconds ?: 0,
            'country_code' => $request->country_code,
            'region_code' => $request->region_code ?: '',
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'offence_date' => $offence_date,
            'ip' => $request->ip(),
            'disable_comments' => $request->disable_comments,
            'disable_map' => $request->disable_map,
            'type' => $request->type
        ];

        $content = $user->addContent($attributes);       

        if ($user->hasRole('user_autoapprove')) {
            $content->approve();
        }

        $content->source = 'mobile';
        $content->save();

        // if ($request->type == 'photo') {
        //     $content->addImages($request->photos);
        // }

        $content->addCategory(['niche_id' => 8]);

        return $this->success([
            'message' => 'Upload success'
        ]);
    }

    public function uploadAvailable()
    {
        $format = format_bytes(disk_free_space('/'));

        // compate free space in GB
        if ($format['size'] > 5) {
            return $this->success([
                'message' => 'Upload is available'
            ]);
        }

        return $this->failed([
            'message' => 'Disk is full'
        ]);
    }
}
