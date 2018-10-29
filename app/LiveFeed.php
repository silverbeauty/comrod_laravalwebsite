<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LiveFeed extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'title',
        'content_url',
        'thumb_url',
        'country_code',
        'region_code',
        'city_name',
        'latitude',
        'longitude',
        'type',
        'refresh_in_seconds',
    ];

    public function getUrlAttribute()
    {
        return route('liveFeed', ['id' => str_slug($this->title . '-' . $this->id)]);
    }
}
