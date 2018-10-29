<?php

namespace App\Uploaders;

use Intervention\Image\Facades\Image as InterventionImage;

class PhotoUploader extends Uploader
{
    public function baseDir()
    {
        return config('app.gallery_path') . remove_extension($this->filename) .'/';
    }

    public function resize()
    {
        InterventionImage::make($this->filePath())
            ->resize(900, 900, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })
            ->save($this->filePath());        

        s3Sync(s3Client(), config('app.gallery_path'), config('app.remote_gallery_path'));       

        return $this;
    }
}