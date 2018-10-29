<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentNiche extends Model
{
    public $timestamps = false;

    protected $fillable = ['content_id', 'niche_id'];

    public function category()
    {
        return $this->belongsTo(\App\Niche::class, 'niche_id')->whereEnabled(1);
    }

    public function getIconUrlAttribute()
    {
        $category = $this->category;

        if ($category) {
            return asset_cdn('images/categories/'.$category->icon);
        }
    }

    public function getNameAttribute()
    {
        $category = $this->category;

        if ($category) {
            return $category->name;
        }
    }
}
