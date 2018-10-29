<?php

namespace App\Uploaders;

class VideoUploader extends Uploader
{
    public function baseDir()
    {
        return config('app.video_upload_path');
    }
}