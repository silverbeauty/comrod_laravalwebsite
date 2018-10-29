<?php

namespace App\Traits;

use App\Slug;

trait Slugable
{
    protected static function bootSlugable()
    {
        static::created(function ($model) {        
            Slug::create([
                'name' => $model->username ?: $model->slug,
                'slugable_id' => $model->id ?: $model->record_num,
                'slugable_type' => get_class(new static),
            ]);
        });
    }

    public function slug()
    {
        return $this->hasOne(\App\Slug::class, 'slugable_id')->whereSlugableType(get_class($this));
    }

    public function updateSlug($slug)
    {
        return $this->slug()->update(['name' => $slug]);
    }
}