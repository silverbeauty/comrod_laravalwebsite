<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OldLicensePlate extends Model
{
    protected $table = 'license_plates';    
    protected $connection = 'roadshamer';
}
