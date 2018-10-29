<?php

return [

    'env' => env('APP_ENV', 'local'),
    'domain' => env('APP_DOMAIN', 'comroads.com'),
    'layout' => env('APP_LAYOUT', 'v1'),
    'protocol' => env('APP_PROTOCOL'),
    'recaptcha' => env('APP_RECAPTCHA'),
    'cache_time' => env('CACHE_TIME'),

    /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

    'debug' => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

    'url' => 'http://' . env('APP_DOMAIN'),

    /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

    'timezone' => 'UTC',

    /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

    'locale' => env('APP_LOCALE', 'en'),

    /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

    'fallback_locale' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

    'key' => env('APP_KEY', 'SomeRandomString'),

    'cipher' => 'AES-256-CBC',

    /*
    |--------------------------------------------------------------------------
    | Logging Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure the log settings for your application. Out of
    | the box, Laravel uses the Monolog PHP logging library. This gives
    | you a variety of powerful log handlers / formatters to utilize.
    |
    | Available Settings: "single", "daily", "syslog", "errorlog"
    |
    */

    'log' => 'single',

    /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

    'providers' => [

        /*
         * Laravel Framework Service Providers...
         */
        Illuminate\Foundation\Providers\ArtisanServiceProvider::class,
        Illuminate\Auth\AuthServiceProvider::class,
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
        Illuminate\Bus\BusServiceProvider::class,
        Illuminate\Cache\CacheServiceProvider::class,
        Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
        Illuminate\Routing\ControllerServiceProvider::class,
        Illuminate\Cookie\CookieServiceProvider::class,
        Illuminate\Database\DatabaseServiceProvider::class,
        Illuminate\Encryption\EncryptionServiceProvider::class,
        Illuminate\Filesystem\FilesystemServiceProvider::class,
        Illuminate\Foundation\Providers\FoundationServiceProvider::class,
        Illuminate\Hashing\HashServiceProvider::class,
        Illuminate\Mail\MailServiceProvider::class,
        Illuminate\Pagination\PaginationServiceProvider::class,
        Illuminate\Pipeline\PipelineServiceProvider::class,
        Illuminate\Queue\QueueServiceProvider::class,
        Illuminate\Redis\RedisServiceProvider::class,
        Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
        Illuminate\Session\SessionServiceProvider::class,
        //Illuminate\Translation\TranslationServiceProvider::class,
        Illuminate\Validation\ValidationServiceProvider::class,
        Illuminate\View\ViewServiceProvider::class,

        /*
         * Application Service Providers...
         */
        App\Providers\AppServiceProvider::class,
        App\Providers\AuthServiceProvider::class,
        App\Providers\EventServiceProvider::class,
        App\Providers\RouteServiceProvider::class,
        App\Providers\ViewComposerServiceProvider::class,
        App\Providers\ConfigServiceProvider::class,

        Barryvdh\Debugbar\ServiceProvider::class,
        Greggilbert\Recaptcha\RecaptchaServiceProvider::class,
        //Laravel\Socialite\SocialiteServiceProvider::class,
        SocialiteProviders\Manager\ServiceProvider::class,
        Intervention\Image\ImageServiceProvider::class,
        Jenssegers\Agent\AgentServiceProvider::class,
        Yajra\Datatables\DatatablesServiceProvider::class,
        Waavi\Translation\TranslationServiceProvider::class,
        GeneaLabs\LaravelCaffeine\LaravelCaffeineServiceProvider::class,
        Cmgmyr\Messenger\MessengerServiceProvider::class,
        Laracasts\Utilities\JavaScript\JavaScriptServiceProvider::class,
        Nathanmac\Utilities\Parser\ParserServiceProvider::class,

    ],

    /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

    'aliases' => [

        'App'       => Illuminate\Support\Facades\App::class,
        'Artisan'   => Illuminate\Support\Facades\Artisan::class,
        'Auth'      => Illuminate\Support\Facades\Auth::class,
        'Blade'     => Illuminate\Support\Facades\Blade::class,
        'Bus'       => Illuminate\Support\Facades\Bus::class,
        'Cache'     => Illuminate\Support\Facades\Cache::class,
        'Config'    => Illuminate\Support\Facades\Config::class,
        'Cookie'    => Illuminate\Support\Facades\Cookie::class,
        'Crypt'     => Illuminate\Support\Facades\Crypt::class,
        'DB'        => Illuminate\Support\Facades\DB::class,
        'Eloquent'  => Illuminate\Database\Eloquent\Model::class,
        'Event'     => Illuminate\Support\Facades\Event::class,
        'File'      => Illuminate\Support\Facades\File::class,
        'Gate'      => Illuminate\Support\Facades\Gate::class,
        'Hash'      => Illuminate\Support\Facades\Hash::class,
        'Input'     => Illuminate\Support\Facades\Input::class,
        'Inspiring' => Illuminate\Foundation\Inspiring::class,
        'Lang'      => Illuminate\Support\Facades\Lang::class,
        'Log'       => Illuminate\Support\Facades\Log::class,
        'Mail'      => Illuminate\Support\Facades\Mail::class,
        'Password'  => Illuminate\Support\Facades\Password::class,
        'Queue'     => Illuminate\Support\Facades\Queue::class,
        'Redirect'  => Illuminate\Support\Facades\Redirect::class,
        'Redis'     => Illuminate\Support\Facades\Redis::class,
        'Request'   => Illuminate\Support\Facades\Request::class,
        'Response'  => Illuminate\Support\Facades\Response::class,
        'Route'     => Illuminate\Support\Facades\Route::class,
        'Schema'    => Illuminate\Support\Facades\Schema::class,
        'Session'   => Illuminate\Support\Facades\Session::class,
        'Storage'   => Illuminate\Support\Facades\Storage::class,
        'URL'       => Illuminate\Support\Facades\URL::class,
        'Validator' => Illuminate\Support\Facades\Validator::class,
        'View'      => Illuminate\Support\Facades\View::class,
        'Recaptcha' => Greggilbert\Recaptcha\Facades\Recaptcha::class,
        'Image'     => Intervention\Image\Facades\Image::class,
        'Agent'     => Jenssegers\Agent\Facades\Agent::class,
        'Datatables' => Yajra\Datatables\Datatables::class,
        'UriLocalizer'  => Waavi\Translation\Facades\UriLocalizer::class,
        'TranslationCache' => \Waavi\Translation\Facades\TranslationCache::class,
        'Parser' => Nathanmac\Utilities\Parser\Facades\Parser::class,
    ],

    //'test_ip' => '49.50.223.255', // New Zealand
    'test_ip' => '206.72.198.26', // United States
    //'test_ip' => '192.206.151.131', // Canada
    //'test_ip' => '110.33.122.75', // Australia
    'asset_base_url' => env('APP_ASSET_BASE_URL'),
    'encoder' => env('VIDEO_ENCODER', 'ffmpeg'),
    'ffmpeg_path' => env('FFMPEG_PATH', ''),
    'video_smil_base_url' => env('VIDEO_SMIL_BASE_URL'),
    'video_base_url' => env('VIDEO_BASE_URL'),
    'video_thumbnail_base_url' => env('VIDEO_THUMBNAIL_BASE_URL'),
    'photo_thumbnail_base_url' => env('PHOTO_THUMBNAIL_BASE_URL'),
    'misc_base_url' => env('MISC_BASE_URL'),
    'valid_subdomains' => ['www', 'dev', 'adroi'],
    'countries_need_state' => ['US', 'AU', 'CA'],
    'image_extensions' => ['jpg','png','gif','bmp','jpeg'],
    'video_extensions' => ['flv','wmv','avi','mov','mp4','3gp','m4v','mpeg','mpg','m4v','f4v'],
    'video_upload_path' => env('VIDEO_UPLOAD_PATH'),
    'photo_upload_path' => env('PHOTO_UPLOAD_PATH'),    
    'video_path' => env('VIDEO_PATH'),
    'video_thumb_path' => env('VIDEO_THUMB_PATH'),
    'video_thumb_embed_path' => env('VIDEO_THUMB_EMBED_PATH'),
    'video_remote_path' => env('VIDEO_REMOTE_PATH'),
    'video_remote_thumb_path' => env('VIDEO_REMOTE_THUMB_PATH'),
    'video_remote_embed_thumb_path' => env('VIDEO_REMOTE_EMBED_THUMB_PATH'),
    'video_remote_temp_path' => env('VIDEO_REMOTE_TEMP_PATH'),
    'misc_path' => env('MISC_PATH'),
    'gallery_path' => env('GALLERY_PATH'),
    'remote_misc_path' => env('REMOTE_MISC_PATH'),
    'remote_gallery_path' => env('REMOTE_GALLERY_PATH'),
    'ftp_path' => 'ftp_content',
    'cache_path' => 'cache',
    'wget_path' => '/usr/bin/wget',    
    'imagick_command' => '-modulate 110,102,100 -sharpen 1x1 -enhance',
    'storage_server_password' => env('STORAGE_SERVER_PASSWORD'),
    'storage_server_ip' => env('STORAGE_SERVER_IP'),
    'player' => env('PLAYER', 'flowplayer'),
    'thumb_width' => env('THUMB_WIDTH'),
    'thumb_height' => env('THUMB_HEIGHT'),
    'encoded_videos' => [
        [
            'exempted_countries' => [],
            'path' => 'media/comroads/videos/',
            'thumb_path' => 'media/comroads/thumbs/',
            'remote_path' => 'encoded/comroads/videos/',
            'remote_thumb_path' => 'encoded/comroads/thumbs/',
            'watermarks_path' => 'images/watermarks/comroads/',
        ],
        [
            'exempted_countries' => ['IL'],
            'path' => 'media/3aksalsir/videos/',
            'thumb_path' => 'media/3aksalsir/thumbs/',
            'remote_path' => 'encoded/3aksalsir/videos/',
            'remote_thumb_path' => 'encoded/3aksalsir/thumbs/',
            'watermarks_path' => 'images/watermarks/3aksalsir/',
        ]
    ]

];
