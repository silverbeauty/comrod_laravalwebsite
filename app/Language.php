<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use SoftDeletes;

    protected $table = 'translator_languages';

    protected $fillable = ['name', 'locale', 'country_code', 'url'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
