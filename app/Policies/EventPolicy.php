<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\Organizer;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    
    public function update(Organizer $organizer, Event $event)
    {
        return $organizer->id == $event->organizer_id;
    }
}
