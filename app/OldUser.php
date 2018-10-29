<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OldUser extends Model
{
    protected $table = 'users';    
    protected $connection = 'roadshamer';
}
