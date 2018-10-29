<?php

namespace App\Traits;

trait UserMutators
{
    public function setPasswordAttribute($password)
    {
        $this->attributes['password'] = bcrypt($password);
    }

    public function setSignupFriendlyAlertsAttribute($value)
    {
        $this->attributes['signup_friendly_alerts'] = $value == 'on' ? true : false;
    }

    public function setSignupParentalAlertsAttribute($value)
    {
        $this->attributes['signup_parental_alerts'] = $value == 'on' ? true : false;
    }

    public function setBirthDayAttribute($value)
    {
        $this->attributes['birth_day'] = $value ?: null;
    }
}