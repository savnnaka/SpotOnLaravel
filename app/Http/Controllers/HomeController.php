<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Auth;
use App\Models\OrganizerProfile;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * shows events
     */
    public function index()
    {
        $events = Event::where('city', 'Tübingen')->latest()->paginate(5);
        return view('home', compact('events'));
    }

    /**
     * shows search form + results for guests
     */
    public function search()
    {
        $searchString = request('search');

        if($searchString){
            $profiles = Search::add(OrganizerProfile::class, ['name', 'description'])->search($searchString);

            $events = Search::add(Event::class, ['title', 'description', 'city'])->search($searchString);
            
            $city = NULL;

        }else {
            // get city via IP address?
            $profiles = NULL;
            $city = "Tübingen";
            $events = Event::where('city', $city)->get();
        }

        return view('search', compact('events', 'profiles', 'searchString', 'city'));
    }
}
