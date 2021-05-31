<?php

namespace App\Listeners\Rating;

use App\Achievements\Chains\DurationChain;
use App\Events\Rating\RatingCreated;
use App\Models\User;

class AwardDurationAchievements
{
    public function handle(RatingCreated $event)
    {
        foreach (User::all() as $user) {
            $points = $user->rating_points()->select('date')->distinct('date')->count();

            $user->setProgress(new DurationChain(), $points);
        }
    }
}
