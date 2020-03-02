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
        $event->student->load('points');

        $event->student->achievements()->sync(
            collect(app('achievements')['points'])->filter->qualifier($event->rating, $event->student)->map->modelKey(),
            false
        ); //TODO: сделать в будущем, чтобы подавалось rating и student для ачивок с очками по категории
    }
}
