<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganizerProfile;

class FollowsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    
    /**
     * $organizerProfile is passed in (profile that our auth user wants to follow or unfollow)
     * toggle switches between 'true' or 'false'
     */
    public function store(OrganizerProfile $organizerProfile){

        auth()->user()->following()->toggle($organizerProfile);
        return redirect("/organizer-profile/{$organizerProfile->id}");
    }
}
