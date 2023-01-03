<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            // if we are coming from anywhere with organizer, we want to be redirected to organizer.login
            // does not seem to work tho
            // if($request->url('organizer/*')){
            //     return route('organizer.login');
            // }
            
            return route('home');
        }
    }
}
