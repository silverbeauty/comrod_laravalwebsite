<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentInactiveYoutube extends Model
{
    protected $table = 'content_inactive_youtube';

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }
}
