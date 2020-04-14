<?php

namespace App\Achievements\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AwardAccountAchievements
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
                collect(app('achievements')['account'])->filter->qualifier($event->user)->map->modelKey(),
                false
            );
        }
    }
}
