<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use App\Models\Event;
use App\Models\OrganizerProfile;

class SearchController extends Controller
{
     /**
     * shows search bar + results and events in the users's/guest's city
     */
    public function search()
    {
        $searchString = request('search');

        if($searchString){
            $profiles = Search::add(OrganizerProfile::class, ['name', 'description'])->search($searchString);

            $events = Search::add(Event::class, ['title', 'description', 'city'])->search($searchString);
            
            $city = NULL;

        }else {
            // TODO: Stadt des Users voreinstellen
            $profiles = NULL;
            $city = "Tübingen";
            $events = Event::where('city', $city)->get();
        }

        return view('search', compact('events', 'profiles', 'searchString', 'city'));
    }
}
