<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\Organizer;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the Organizer can view any models.
     *
     * @param  \App\Models\Organizer  $organizer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function viewAny(Organizer $organizer)
    {
        //
    }

    /**
     * Determine whether the Organizer can view the model.
     *
     * @param  \App\Models\Organizer  $organizer
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function view(Organizer $organizer, Event $event)
    {
        //
    }

    /**
     * Determine whether the Organizer can create models.
     *
     * @param  \App\Models\Organizer  $organizer
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function create(Organizer $organizer)
    {
        //
    }

    /**
     * Determine whether the Organizer can update the model.
     * Not used
     *
     * @param  \App\Models\Organizer  $organizer
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(Organizer $organizer, Event $event)
    {
        return $organizer->id == $event->organizer_id;
        
    }

    /**
     * Determine whether the Organizer can delete the model.
     *
     * @param  \App\Models\Organizer  $organizer
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(Organizer $organizer, Event $event)
    {
        //
    }

    /**
     * Determine whether the Organizer can restore the model.
     *
     * @param  \App\Models\Organizer  $organizer
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function restore(Organizer $organizer, Event $event)
    {
        //
    }

    /**
     * Determine whether the Organizer can permanently delete the model.
     *
     * @param  \App\Models\Organizer  $organizer
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function forceDelete(Organizer $organizer, Event $event)
    {
        //
    }
}
