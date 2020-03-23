<?php

namespace App\Policies;

use App\Chat\Chat;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ChatPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function tune(User $user, Chat $chat)
    {
        return $chat->ownerId === $user->id;
    }

    public function write(User $user, Chat $chat)
    {
        return $this->affect($user, $chat);
    }

    public function show(User $user, Chat $chat)
    {
        return $this->affect($user, $chat);
    }

    public function affect(User $user, Chat $chat)
    {
        return $user->isInChat($chat);
    }
}
