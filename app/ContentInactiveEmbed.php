<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentInactiveEmbed extends Model
{
    protected $table = 'content_inactive_embed';

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }
}
