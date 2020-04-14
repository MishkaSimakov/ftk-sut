<?php

namespace App\Achievements\Listeners;

use App\StudentAchievement;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AwardLikeAchievements
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
        if ($event->user->student) {
            $event->user->student->achievements()->sync(
                collect(app('achievements')['likes'])->filter->qualifier($event->article, $event->user)->map->modelKey(),
                false
            );
        }
    }
}
