<?php

namespace App\Listeners\Rating;

use App\Achievements\Chains\DurationChain;
use App\Events\Rating\RatingCreated;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;

class AwardDurationAchievements implements ShouldQueue
{
    public function handle(RatingCreated $event)
    {
        foreach (User::with('rating_points')->get() as $user) {
            $points = $user->rating_points()->select('date')->distinct('date')->count();

            $user->setProgress(new DurationChain(), $points);
        }
    }
}
