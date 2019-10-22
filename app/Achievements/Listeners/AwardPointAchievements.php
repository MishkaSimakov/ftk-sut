<?php

namespace App\Achievements\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AwardPointAchievements
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
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        $event->point->user->achievements()->sync(
            collect(app('achievements')['points'])->filter->qualifier($event->point)->map->modelKey()
        );
    }
}
