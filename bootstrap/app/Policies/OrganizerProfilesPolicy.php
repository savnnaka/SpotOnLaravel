<?php

namespace App\Policies;

use App\Models\Organizer;
use App\Models\OrganizerProfile;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrganizerProfilesPolicy
{
    use HandlesAuthorization;

    public function update(Organizer $organizer, OrganizerProfile $profile)
    {
        //$organizer_id = Auth::guard('organizer')->id;
        return $organizer->id == $profile->organizer_id;
    }
}
