<?php

namespace App\Providers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->composeHeaderNavigation([]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        
    }

    /**
     * Compose the header navigation bar.
     * 
     * @return void 
     */
    private function composeHeaderNavigation(array $data)
    {        
        $request = Request::capture();
        $ip = user_ip();

        view()->composer('*', function ($view) use($request, $ip) {
            $signed_in = Auth::check();
            $user = $signed_in ? Auth::user() : new User;
            $view->with([
                'signed_in' => $signed_in,
                'user_id' => $user->id,
                'user' => $user,
                'route_name' => Route::currentRouteName(),
                'request' => $request,
                'default_country_code' => @geoip_country_code_by_name($ip),
                'default_country_name' => @geoip_country_name_by_name($ip),
                'user_geo' => @geoip_record_by_name($ip),
                'is_ajax' => $request->ajax(),
                'layout' => session('layout') ?: config('app.layout')              
            ]);                 
        });

        view()->composer(['partials.header', 'profiles.user'], function ($view) {
            $signed_in = Auth::check();
            $user = $signed_in ? Auth::user() : new User;
            $total_messages = total_messages($user);
            $total_notifications = $total_messages + $user->total_notifications;

            $view->with([                
                'total_messages' => $total_messages,
                'total_notifications' => $total_notifications,
            ]);
        });
    }
}
