<?php

namespace App\Achievements\Events;

use App\User;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class UserGoToTravel
{
    use Dispatchable, SerializesModels;

    public $user;


    public function __construct(User $user)
    {
        $this->user = $user;
    }
}
