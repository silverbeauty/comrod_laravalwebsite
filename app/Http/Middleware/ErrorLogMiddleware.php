<?php

namespace App\Http\Middleware;

use Illuminate\Support\ViewErrorBag;
use Closure;
use Exception;
use DateTime;

class ErrorLogMiddleware
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
        $errors = $request->session()->get('errors', new ViewErrorBag);
        if ($errors->has()) {
            try {
                $result = array_merge($errors->all(), [
                    'ip' => $request->ip(),
                    'url' => $request->url(),
                    'method' => $request->method(),
                    'date' => new DateTime
                ]);
                $message = json_encode($result);
                errorLog()->set($message);
            } catch (Exception $exception) {
                errorLog()->set($exception->getMessage());
            }
        }
        return $next($request);
    }
}
