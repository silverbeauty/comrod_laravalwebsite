<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        config([
            'services.facebook.redirect' => route('auth::getSocialLoginCallback', 'facebook'),
            'services.twitter.redirect' => route('auth::getSocialLoginCallback', 'twitter'),
            'services.pinterest.redirect' => route('auth::getSocialLoginCallback', 'pinterest'),
            'services.vimeo.redirect' => route('auth::getSocialLoginCallback', 'vimeo'),
            'services.google.redirect' => route('auth::getSocialLoginCallback', 'google'),
        ]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
