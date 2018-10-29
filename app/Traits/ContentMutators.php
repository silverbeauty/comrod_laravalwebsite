<?php

namespace App\Traits;

trait ContentMutators
{
    public function setOffenceDateAttribute($value)
    {
        $this->attributes['offence_date'] = $value;
    }

    public function setAgreementAttribute($value)
    {
        $this->attributes['agreement'] = $value == 'on' ? true : false;
    }

    public function setDisableCommentsAttribute($value)
    {
        $this->attributes['disable_comments'] = $value == 'on' ? true : false;
    }

    public function setDisableMapAttribute($value)
    {
        $this->attributes['disable_map'] = $value == 'on' ? true : false;
    }

    public function setPrivateAttribute($value)
    {
        $this->attributes['private'] = $value == 'on' ? true : false;
    }
} 