<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class TranslatorExcludedCountry extends Model
{
    protected $fillable = ['country_code'];
}
