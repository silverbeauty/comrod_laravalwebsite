<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slug extends Model
{
    protected $fillable = ['name', 'slugable_id', 'slugable_type'];

    public function slugable()
    {
        return $this->morphTo();
    }
}
