<?php

namespace App\Traits;

use Carbon\Carbon;

trait UserAccessors
{
    public function getUrlAttribute()
    {
        return route('getUserProfile', strtolower($this->username).'-'.$this->id);
    }

    public function getSettingsUrlAttribute()
    {
        return route('account::getSettings');
    }

    public function getEditProfileUrlAttribute()
    {
        return route('getUserEditProfile', $this->username);
    }

    public function getMessagesUrlAttribute()
    {
        return route('messages::index');
    }

    public function getUploadsUrlAttribute()
    {
        return route('getUserUploads', $this->username);
    }

    public function getVideosUrlAttribute()
    {
        return route('getUserVideos', $this->username);
    }

    public function getPhotosUrlAttribute()
    {
        return route('getUserPhotos', $this->username);
    }

    public function getMediumAvatarAttribute()
    {
        return $this->avatar('medium');
    }

    public function getSmallAvatarAttribute()
    {
        return $this->avatar('small');
    }

    protected function avatar($size)
    {
        $heights = [
            'small' => 50,
            'medium' => 150
        ];

        $avatar = default_avatar($size);

        if (!is_null($this->avatar)) {
            $url = config('app.misc_base_url') . $this->avatar;
            $avatar = route('images::url', ['url' => $url, 'height' => $heights[$size]]);
        }

        if (!is_null($this->avatar_social) && is_null($this->avatar)) {
            $avatar = $this->avatar_social;
        }

        return str_replace(config('app.url') . '/', config('app.asset_base_url'), $avatar);
    }

    public function getGenderAttribute($value)
    {
        return $value ?: 'Not available';
    }

    public function getAgeAttribute()
    {
        return $this->birth_day ? Carbon::now()->diffInYears(Carbon::createFromFormat('Y-m-d', $this->birth_day)) : 'Not available';
    }

    public function getCountryNameAttribute()
    {
        $country = $this->country;

        return $country ? $country->name : 'Not available';
    }

    public function getDateJoinedAttribute()
    {
        return $this->created_at->format('d. m. Y.');
    }

    public function getFormattedLastLoginAttribute()
    {
        return !is_null($this->last_login) ? $this->last_login->format('d. m. Y.') : 'Not available';
    }

    public function getTotalUnreadDiscussionsAttribute()
    {
        if (is_null($this->totalUnreadDiscussion)) {
            $this->totalUnreadDiscussion = $this->activities()->whereType('discussion')->whereRead(0)->get()->count();
        }

        return $this->totalUnreadDiscussion;
    }

    public function getDiscussionsUrlAttribute()
    {
        return route('getDiscussions');
    }

    public function getTotalNotificationsAttribute()
    {
        return $this->total_unread_discussions;
    }

    public function getTotalVideosAttribute()
    {
        if (is_null($this->totalVideos)) {
            $this->totalVideos = $this->videos->count();
        }

        return $this->totalVideos;
    }

    public function getTotalPhotosAttribute()
    {
        if (is_null($this->totalPhotos)) {
            $this->totalPhotos = $this->photos->count();
        }

        return $this->totalPhotos;
    }

    public function getTotalContentsAttribute()
    {
        if (is_null($this->totalContents)) {
            $this->totalContents = $this->contents->count();
        }

        return $this->totalContents;
    }    
}