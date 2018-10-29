<?php

namespace App;

use DateTime;
use Carbon\Carbon;
use App\Traits\Slugable;
use App\Services\Messenger;
use App\Traits\UserMutators;
use Illuminate\Http\Request;
use App\Traits\UserAccessors;
use App\Events\UserHasRegistered;
use Illuminate\Auth\Authenticatable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Cmgmyr\Messenger\Traits\Messagable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;

class User extends Model implements AuthenticatableContract,
                                    AuthorizableContract,
                                    CanResetPasswordContract
{
    use Authenticatable,
        Authorizable,
        CanResetPassword,
        SoftDeletes,
        Slugable,
        UserMutators,
        UserAccessors,
        Messagable;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'users';    

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'salt',
        'gender',
        'country_code',
        'city_id',
        'birth_day',
        'friendly_alerts',
        'parental_alerts',
        'verified_email',
        'email_verification_token',
        'avatar',
        'avatar_social',
        'facebook_id',
        'twitter_id',
        'pinterest_id',
        'vimeo_id',
        'google_id',
        'registration_ip',
        'last_ip',
        'last_login',
        'last_last_login',
        'points',
        'gcm_token',
        'user_agent',
        'old_user',
        'deleted_at',
        'created_at',
        'updated_at'        
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = ['password', 'remember_token'];

    protected $dates = ['last_login', 'last_last_login'];

    protected $totalUnreadDiscussion = null;

    protected $totalVideos = null;

    protected $totalPhotos = null;

    protected $totalContents = null; 

    public static function boot()
    {
        parent::boot();

        static::created(function ($user) {
            event(new UserHasRegistered($user));
        });

        static::creating(function ($user) {            
            $user->email_verification_token = str_random(60);

            if (session('social.email')) {
                $user->verified_email = true;
                $user->email_verification_token = null;
            }
        });
    }

    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'code');
    }

    public function plate()
    {
        return $this->hasOne(SubscriberPlate::class, 'user_id');
    }

    public function videos()
    {
        return $this->hasMany(Content::class, 'user_id')
                ->whereType('video')
                ->whereIn('approved', [1, 0])
                ->whereEnabled(1);
    }

    public function photos()
    {
        return $this->hasMany(Content::class, 'user_id')
                ->whereType('photo')
                ->whereIn('approved', [1, 0])
                ->whereEnabled(1);
    }

    public function contents($userId = null)
    {
        $query = $this->hasMany(Content::class, 'user_id')->whereIn('approved', [1, 0])->whereEnabled(1);

        if ($userId != $this->id) {
            return $query->wherePrivate(0);            
        }

        return $query;

    }

    public function activities()
    {
        return $this->hasMany(Activity::class, 'user_id');
    }

    public function watched()
    {
        return $this->hasMany(UserWatched::class, 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class);
    }

    public function translatorExcludedCountries()
    {
        return $this->hasMany(TranslatorExcludedCountry::class, 'translator_id');
    }

    public function assignLanguage($language)
    {
        return $this->languages()->save(
            Language::whereName($language)->firstOrFail()
        );
    }

    public function assignLanguages(array $languages)
    {
        foreach ($languages as $language) {
            $this->assignLanguage($language);
        }

        return $this;
    }

    /**
     * Add countries to be excluded for translation
     * 
     * @param string|array $country_code
     * @return  App\User
     */
    public function addTranslatorExcludedCountries($country_code)
    {
        if (is_string($country_code)) {
            $this->translatorExcludedCountries()->save(new TranslatorExcludedCountry(['country_code' => $country_code]));
        }

        if (is_array($country_code)) {
            $instances = [];
            foreach ($country_code as $key => $code) {
                $instances[] = new TranslatorExcludedCountry(['country_code' => $code]);
            }

            $this->translatorExcludedCountries()->saveMany($instances);
        }

        return $this;
    }

    public function own($user_id)
    {
        return $this->id == $user_id;
    }

    public function removeLanguage($language_id)
    {
        return $this->languages()->detach($language_id);
    }

    public function assignRole($role, $sendEmail = true)
    {
        if ($role == 'user_autoapprove' && $sendEmail) {
            $this->sendUserAutoApproveMessage();
        }

        return $this->roles()->save(
            Role::whereName($role)->firstOrFail()
        );
    }

    public function sendUserAutoApproveMessage()
    {
        $attributes = [
            'subject' => trans('app.user_auto_approve_message_subject'),
            'body' => trans('app.user_auto_approve_message_body'),
            'sender_id' => Auth::user()->id,
            'recipients' => [$this->id]
        ];

        Messenger::send($attributes);
    }

    public function removeRole($role_id)
    {
        return $this->roles()->detach($role_id);
    }

    public function hasRole($role)
    {
        if (is_string($role)) {
            return $this->roles->contains('name', $role);
        }

        return !! $role->intersect($this->roles)->count();
    }

    public function doesntHaveRoleOf($role)
    {
        if (is_string($role)) {
            return ! $this->roles->contains('name', $role);
        }

        if (is_array($role)) {
            $roles = $this->roles;
            foreach ($role as $value) {
                if (is_string($value) && $roles->contains('name', $value)) {
                    return false;
                }
            }

            return true;
        }

        return $role->intersect($this->roles)->count();
    }

    public function hasLanguage($locale)
    {
        if (is_string($locale)) {
            return $this->languages->contains('locale', $locale);
        }

        return !! $locale->intersect($this->languages)->count();
    }

    public function verifyEmail()
    {
        $this->verified_email = true;
        $this->email_verification_token = null;
        $this->save();
    }

    public function updateEmail($new_email)
    {
        $this->email = $new_email;
        $this->verified_email = false;
        $this->email_verification_token = str_random(60);
        $mailer = app(\App\Mailers\UserMailer::class);
        $mailer->sendEmailConfirmation($this);
        $this->save();
    }

    public function updateAvatar($filename)
    {
        $this->avatar = $filename;
        $this->save();
    }

    public function changePassword($password)
    {
        $this->password = $password;
        $this->old_user = false;
        $this->save();
    }

    public function updateLoginInfo(Request $request)
    {
        return $this->update([
            'last_ip' => $request->ip(),
            'user_agent' => user_agent(),
            'last_login' => Carbon::now(),
            'last_last_login' => $this->getOriginal('last_login'),
        ]);
    }

    public function checkPassword($password)
    {
        return Hash::check($password, $this->password);
    }

    public function addPlate(array $attributes)
    {
        return $this->plate()->save(new SubscriberPlate($attributes));
    }

    public function addContent(array $attributes) {
        return $this->contents()->save(new Content($attributes));
    }

    public function addWatched(Content $content, $ip = null)
    {
        $userWatched = ['content_id' => $content->id];
        if (!is_null($ip)) {
            $userWatched['ip'] = $ip;
        }
        return $this->watched()->save(new UserWatched($userWatched));
    }

    public function isWatched(Content $content)
    {
        return $this->watched()->whereContentId($content->id)->first();
    }

    public function isWatchedToday(Content $content)
    {
        $from   = (new DateTime)->format('Y-m-d 00:00:00'); 
        $to     = (new DateTime)->format('Y-m-d 23:59:59');
        return $this->watched()
            ->whereBetween('created_at', [$from, $to])
            ->whereContentId($content->id)
            ->first();
    }

    public function canTranslate($locale)
    {
        return $this->can('translate') && $this->hasLanguage($locale) || $this->hasRole('super_admin');
    }
}
