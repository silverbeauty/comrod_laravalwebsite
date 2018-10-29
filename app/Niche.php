<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Niche extends Model
{
    public $timestamps = false;

    protected $casts = [
        'name_translated' => 'array'
    ];

    public function getIconUrlAttribute()
    {
        return asset_cdn('images/categories/'.$this->icon);
    }

    public function getNameAttribute()
    {
        $lang = subdomain();
        if ($lang != 'en') {
            $translations = is_array($this->name_translated) ? $this->name_translated : json_decode($this->name_translated, true);

            if (isset($translations[$lang]) && $translations[$lang]) {
                return $translations[$lang];
            }
        }

        return $this->attributes['name'];
    }
}
