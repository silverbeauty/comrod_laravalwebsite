<?php

namespace App\Http\Controllers;

use Aws\S3\S3Client;
use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class TestController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function apiUploadTest()
    {
        //Storage::disk('s3')->put('uploads/videos/', file_get_contents(public_path('uploads/videos/')));
        
        // $client = S3Client::factory([
        //     'version' => '2006-03-01',
        //     'credentials' => [
        //         'key' => config('filesystems.disks.s3.key'),
        //         'secret' => config('filesystems.disks.s3.secret'),
        //     ],
        //     'region' => config('filesystems.disks.s3.region'),            
        // ]);

        // $client->uploadDirectory(public_path('test'), config('filesystems.disks.s3.bucket'));

        return view('tests.api_upload_test');
    }
}
