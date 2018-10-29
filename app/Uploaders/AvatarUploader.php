<?php

namespace App\Uploaders;

use Intervention\Image\Facades\Image as InterventionImage;

class AvatarUploader extends Uploader
{
    public function baseDir()
    {
        return config('app.misc_path');
    }

    public function resize()
    {
        InterventionImage::make($this->filePath())
            ->resize(900, 900, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save($this->filePath());        

        s3sync(s3Client(), config('app.misc_path'), config('app.remote_misc_path'));

        return $this;
    }
}