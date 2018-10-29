<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GCMAlert extends Model
{
    protected $table = 'gcm_alerts';

    public function owner()
    {
        return $this->belongsTo(\App\User::class, 'from_user_id');
    }
}
