<?php

namespace App\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->bootPinterestProvider();
        $this->youtubeUrlValidationRules();
        $this->vidmeUrlValidationRules();
        //$this->queueAfter();
    }

    private function queueAfter()
    {
        Queue::after(function ($connection, $job, $data) {            
            $command = unserialize($data['data']['command']);
            
            if (get_class($command) == 'App\Jobs\EncodeVideo') {                
                $video = $command->getVideo();
                $video->createThumbnail();
            }            
        });
    }

    private function bootPinterestProvider()
    {
        $socialite = app('Laravel\Socialite\Contracts\Factory');
        $socialite->extend(
            'pinterest',
            function ($app) use ($socialite) {
                $config = $app['config']['services.pinterest'];
                return $socialite->buildProvider(\App\Socialite\PinterestProvider::class, $config);
            }
        );
    }

    private function youtubeUrlValidationRules()
    {
        Validator::extend('youtube', function ($attribute, $value, $parameters, $validator) {
            $rx = '~
                    ^(?:https?://)?              # Optional protocol
                     (?:www\.)?                  # Optional subdomain
                     (?:youtube\.com|youtu\.be)  # Mandatory domain name
                     /(watch\?v=|embed/)?([^&]+)           # URI with video id as capture group 1
                     ~x';

            $has_match = preg_match($rx, $value, $matches);

            if ($has_match) {
                $response = @file_get_contents('http://www.youtube.com/oembed?url='.$value);
                if (!empty($response)) {
                    return true;
                }
            }

            return false;
        });
    }

    private function vidmeUrlValidationRules()
    {
        Validator::extend('vidme', function ($attribute, $value, $parameters, $validator) {
            $rx = '~
                    ^(?:https?://)?              # Optional protocol
                     (?:www\.)?                  # Optional subdomain
                     (?:vid\.me)                 # Mandatory domain name
                     /([^&]+)                    # video id
                     ~x';

            $has_match = preg_match($rx, $value, $matches);

            if ($has_match) {
                $response = @file_get_contents('https://api.vid.me/videoByUrl/'.$matches[1]);
                if (!empty($response)) {
                    return true;
                }
            }

            return false;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() == 'local') {
            $this->app->register('Laracasts\Generators\GeneratorsServiceProvider');
            $this->app->register('SocialiteProviders\Generators\GeneratorsServiceProvider');
        }
    }
}
