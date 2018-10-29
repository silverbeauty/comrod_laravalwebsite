<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Ad extends Model
{
    use SoftDeletes;

    protected $fillable = ['label', 'code'];
}
