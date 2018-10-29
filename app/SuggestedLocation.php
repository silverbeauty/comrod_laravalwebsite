<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class SuggestedLocation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'content_id',
        'country_code',
        'region_code',
        'city_name',
        'latitude',
        'longitude'
    ];

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function region()
    {
        return $this->belongsTo(Region::class, 'region_code', 'code')->whereCountryCode($this->country_code);
    }

    public function getStateNameAttribute()
    {
        $region = $this->region;

        return $region ? $region->name : null; 
    }
}
