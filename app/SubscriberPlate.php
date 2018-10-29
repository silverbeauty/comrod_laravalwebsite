<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubscriberPlate extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'brand_id',
        'model_id',
        'type_id',
        'colour_id',
        'country_code',
        'region_code'
    ];
}
