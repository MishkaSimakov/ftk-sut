<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any events.
     *
     * @param ?User $user
     * @return bool
     */
    public function viewAny(?User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the event.
     *
     * @param ?User $user
     * @param Event $event
     * @return bool
     */
    public function view(?User $user, Event $event)
    {
        return true;
    }

    /**
     * Determine whether the user can create events.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can update the event.
     *
     * @param User $user
     * @param Event $event
     * @return bool
     */
    public function update(User $user, Event $event)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can delete the event.
     *
     * @param User $user
     * @param Event $event
     * @return bool
     */
    public function delete(User $user, Event $event)
    {
        return $user->is_admin;
    }

    /**
     * Determine whether the user can sign up for the event.
     *
     * @param User $user
     * @param Event $event
     * @return bool
     */
    public function signUp(User $user, Event $event)
    {
        return $event->date_start->isFuture();
    }

    /**
     * Determine whether the user can update event users list.
     *
     * @param User $user
     * @param Event $event
     * @return bool
     */
    public function changeUsersList(User $user, Event $event)
    {
        return $user->is_admin;
    }
}
