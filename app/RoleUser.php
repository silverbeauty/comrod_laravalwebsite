<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_user';

    protected $casts = ['speaks_languages' => 'array'];

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}
