<?php

namespace App\Uploaders;

use Symfony\Component\HttpFoundation\File\UploadedFile;

abstract class Uploader
{
    protected $file;
    protected $filename;

    public function upload(UploadedFile $file)
    {
        $this->file = $file;
        $this->filename = $this->filename();

        set_time_limit(0);
        
        $this->file->move($this->baseDir(), $this->filename);

        return $this;
    }

    protected function filename()
    {
        $name = sha1(
            time() . $this->file->getClientOriginalName()
        );

        $extension = $this->file->getClientOriginalExtension();

        return "{$name}.{$extension}";
    }

    public function filePath()
    {
        return $this->baseDir() . $this->filename;
    }

    public function url()
    {
        return asset($this->filePath());
    }

    public function getFilename()
    {
        return $this->filename;
    }

    abstract protected function baseDir();
}