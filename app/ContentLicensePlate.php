<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentLicensePlate extends Model
{
    public $timestamps = false;

    protected $fillable = ['content_id', 'license_id'];

    public function info()
    {
        return $this->belongsTo(LicensePlate::class, 'license_id');
    }

    public function content()
    {
        return $this->belongsTo(Content::class, 'content_id');
    }
}
