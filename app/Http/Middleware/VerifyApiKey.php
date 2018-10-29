<?php

namespace App\Http\Middleware;

use Closure;

class VerifyApiKey
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
        if ($request->key != env('APP_API_KEY')) {
            return ['success' => false, 'response' => ['message' => 'Access denied']];
        }

        return $next($request);
    }
}
