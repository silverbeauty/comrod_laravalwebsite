<?php

namespace App\Http\Middleware;

use Closure;

class RedirectIfInvalidSubdomain
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (is_valid_subdomain()) {
            return $next($request);
        }

        return redirect()->to('//www.'.env('APP_DOMAIN'));
    }
}
