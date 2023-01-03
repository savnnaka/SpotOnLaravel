<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Organizer\OrganizerController;

class IsOrganizerVerified
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(!Auth::guard('organizer')->user()->email_verified){
            Auth::guard('organizer')->logout();
            return redirect()->route('organizer.login')->with('error', 'You need to confirm your account, 
            we have sent you an activation link');
        }
        return $next($request);
    }
}
