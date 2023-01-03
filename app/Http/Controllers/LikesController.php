<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;

class LikesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * $event is passed in (event that our auth user wants to like or unlike)
     * toggle switches between 'true' or 'false'
     */
    public function store(Event $event){

        auth()->user()->likings()->toggle($event);
        return redirect("/event/{$event->id}");
    }
}
