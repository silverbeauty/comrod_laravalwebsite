<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WatchLog extends Model
{
    protected $table = 'watch_log';

    public function contentItem()
    {
        return $this->belongsTo(\App\Content::class, 'content');
    }
}
