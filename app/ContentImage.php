<?php

namespace App;

use Intervention\Image\Facades\Image;
use Illuminate\Database\Eloquent\Model;

class ContentImage extends Model
{
    protected $fillable = ['content_id', 'filename'];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function url($originalFilename, $height)
    {
        $image = config('app.photo_thumbnail_base_url') . remove_extension($originalFilename ?: $this->filename) . '/' . $this->filename;        

        return route('images::url', ['url' => $image, 'height' => $height]);
    }    

    public function size($originalFilename)
    {
        $subDir = remove_extension($originalFilename ?: $this->filename);

        $head = array_change_key_case(get_headers(config('app.photo_thumbnail_base_url') . $subDir . '/' . $this->filename, TRUE));
        $filesize = $head['content-length'];

        return $filesize;
    }
}
