<?php

namespace App\Achievements;

use App\Achievements\UserEarnedPoints;

class AwardAchievements
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserEarnedPoints  $event
     * @return void
     */
    public function handle(UserEarnedPoints $event)
    {
        $event->point->user->achievements()->sync(
            app('achievements')->filter->qualifier($event->point)->map->modelKey()
        );
    }
}
