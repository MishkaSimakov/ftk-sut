<?php

namespace App\Achievements\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AwardArticleAchievements
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
        if ($event->article->user->student) {
            $event->article->user->student->achievements()->sync(
                collect(app('achievements')['articles'])->filter->qualifier($event->article)->map->modelKey(),
                false
            );
        }
    }
}