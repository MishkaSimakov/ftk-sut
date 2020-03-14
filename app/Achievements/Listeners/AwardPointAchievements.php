<?php

namespace App\Achievements\Listeners;

use App\StudentAchievement;
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
        $event->student->achievements()->sync(
            collect(app('achievements')['points'])->filter->qualifier($event->rating, $event->student, $event->points)->map->modelKey(),
            false
        );
    }
}
