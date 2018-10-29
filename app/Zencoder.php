<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Zencoder extends Model
{
    protected $fillable = ['id', 'content_id'];

    public function content()
    {
        return $this->belongsTo(\App\Content::class, 'content_id');
    }
}
