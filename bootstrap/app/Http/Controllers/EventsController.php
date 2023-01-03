<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Event;
use Auth;


class EventsController extends Controller
{
    public function __construct()
    {
        // if(Auth::guard('web')->check()){
        //     $this->middleware('auth:web');
        // }
        // if(Auth::guard('organizer')->check()){
        //     $this->middleware('auth:organizer');
        // }

        // only organizers can create, store, edit, update and delete events
        $this->middleware('auth:organizer', ['except' => ['show', 'index']]);
        // only users can see all events of OrganizerProfiles that they follow
        $this->middleware('auth:web', ['only' => ['index']]);
    }


    /**
     * shows events of all organizers, that the user follows
     */
    public function index()
    {
        //get the organizer_ids of all the profiles that the user follows
        $followed_profiles = auth()->user()->following()->pluck('organizer_profiles.organizer_id');

        // the with('user') will make the query faster (no limit 1)
        $events = Event::whereIn('organizer_id', $followed_profiles)->with('organizer')->where('date', '>', now())->orderBy('date', 'ASC')->paginate(5);

        return view('events.index', compact('events'));

    }

    /**
     * shows an event
     */
    public function show(Event $event)
    {
        return view('events.show', compact('event'));
    }



    /////////////////////// methods for organizers ///////////////////////////////////////

    /**
     * create a new event. only for organizers 
     */
    public function create()
    {
        return view('events.create');
    }


    public function store()
    {
        //$this->authorize('create');

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'date'=> ['', 'date'], 
            'city' => '',
            'image' => ['', 'image'],
        ]);
        


        if(request('image'))
        {
            $image_b64 = base64_encode(file_get_contents(request()->file('image')));
            $data['image'] = $image_b64;
            // $imagePath = $this->getImagePath(request('image'));
            // $data['image'] = $imagePath;
        }
        // create event through organizer (get organizer_id automatically):
        $event = auth()->user()->events()->create($data);

        return redirect("event/{$event->id}");
    }


    /**
     * edit an existing event
     * only the owner of this event (organizer)
     */
    public function edit(Event $event)
    {
        // use EventPolicy to check if user is allowed to update the profile
        $this->authorize('update', $event);
        return view('events.edit', compact('event'));
    }


    /**
     * only the owner of this event (organizer)
     */
    public function update(Event $event)
    {
        // use EventPolicy to check if user is allowed to update the profile
        $this->authorize('update', $event);
        
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'date'=> ['', 'date'], 
            'city' => '',
            'image' => ['', 'image'],
        ]);

        if(request('image'))
        {
            //$resizedImg = $this->resizeImage(file_get_contents(request()->file('image')));
            $image_b64 = base64_encode(file_get_contents(request()->file('image')));
            $data['image'] = $image_b64;
            // $imagePath = $this->getImagePath($request->file('image'));
            // $data['image'] = $imagePath;
        }
        // create event through organizer (get organizer_id automatically):
        auth()->user()->events()->where('id', $event->id)->update($data);

        return redirect("event/{$event->id}");
    }

    /////////////////////////// HELPER ////////////////////////////////////

    // edit and store uploaded image and return path
    public function getImagePath($uploadedImg)
    {
        $orgPath = $uploadedImg->store('/public/uploads', 'local');
        $imagePath = str_replace("public", "storage", $orgPath);

        /* resize using Image Intervention Package  */
        //$image = Image::make(public_path($imagePath))->fit(1200, 800); 
        $image = Image::make($uploadedImg->getRealPath());
        $image->save();

        return $imagePath;
    }

    public function resizeImage($uploadedImg)
    {
        return Image::make($uploadedImg)->fit(1200, 800);
    }
}
