<?php

namespace App\Policies;

use App\Schedule;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SchedulePolicy
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

    public function sign(User $user, Schedule $schedule)
    {
        return now()->lt($schedule->date_start);
    }
}
