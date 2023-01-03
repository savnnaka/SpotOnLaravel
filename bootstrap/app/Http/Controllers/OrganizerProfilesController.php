<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrganizerProfile;
use App\Models\Organizer;
use Auth;


class OrganizerProfilesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(OrganizerProfile $organizerProfile)
    {
        //$profile = OrganizerProfile::findOrFail($id);
        $follows = NULL;
        if(Auth::guard('web')->check()){
            $user = Auth::guard('web')->user();
            ($user->following->contains($organizerProfile->id)) ? $follows = 'Unfollow' : $follows = 'Follow';
        }
        return view('organizer.profile.show', compact('organizerProfile', 'follows'));
    }

    /**
     * Show the form for editing the specified profile.
     * Only the owner can edit this.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OrganizerProfile $organizerProfile)
    {
        $organizer_id = $organizerProfile->organizer_id;

        $organizer = Auth::guard('organizer')->user();

        //$this->authorize('update', $organizer, $organizerProfile); //won't work

        if($organizer){
            if($organizer->id == $organizerProfile->organizer_id){
                return view('organizer.profile.edit', compact('organizerProfile'));
            }
        }else {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, OrganizerProfile $organizerProfile)
    {
        $organizer = Auth::guard('organizer')->user();

        if( ! $organizer->id == $organizerProfile->organizer_id){
            abort(403);
        } 

        //$this->authorize('update', $organizer, $organizerProfile);

        $data = request()->validate([
            'name' => '',
            'description' => '',
            'contact' => '',
            'image' => ['', 'image'],
        ]);


        if(request('image'))
        {
            $image_b64 = base64_encode(file_get_contents(request()->file('image')));
            $data['image'] = $image_b64;
        }

        // update event through organizer (get organizer_id automatically):
        $organizer->profile->where('id', $organizerProfile->id)->update($data);

        return redirect("/organizer-profile/{$organizerProfile->id}");
    }

}
