<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        'zencoder/notifications',
        'mobile/api/upload/video',
        'mobile/api/upload/photo',
        'mobile/api/login',
        'mobile/api/signup',
        'mobile/api/account',
        'mobile/api/social-login',
        'mobile/api/social-signup',
        'mobile/api/search-by-plate',
        'mobile/api/upload/content',
        'mobile/api/upload/available',
        'upload/upload-video',
        'api/*'
    ];
}
