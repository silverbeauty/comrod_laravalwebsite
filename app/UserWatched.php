<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserWatched extends Model
{
    protected $table = 'user_watched';
    protected $fillable = ['ip', 'user_id', 'content_id'];

    public function content()
    {
        return $this->belongsTo(Content::class);
    }
}
