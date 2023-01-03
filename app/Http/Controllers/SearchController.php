<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ProtoneMedia\LaravelCrossEloquentSearch\Search;
use App\Models\Event;
use App\Models\OrganizerProfile;
use Auth;

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

            $events = Search::add(Event::class, ['title', 'description', 'city'])->search($searchString)->where('date', '>', now());
            
            $city = NULL;

        }else {
            $profiles = NULL;
            // city of user or organizer or via IP (not implemented, Tübingen as default)
            if(Auth::guard('web')->check()){
                if(Auth::guard('web')->user()->city){
                    $city = Auth::guard('web')->user()->city;
                }
            }elseif(Auth::guard('organizer')->check()){
                if(Auth::guard('organizer')->user()->city){
                    $city = Auth::guard('organizer')->user()->city;
                }
            }else {
                $city = "Tübingen";
            }
            // find events of that city
            $events = Event::where('city', $city)->get();
        }

        return view('search', compact('events', 'profiles', 'searchString', 'city'));
    }
}
