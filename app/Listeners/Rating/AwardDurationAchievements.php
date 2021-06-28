<?php

namespace App\Listeners\Rating;

use App\Achievements\Chains\DurationChain;
use App\Events\Rating\RatingCreated;
use App\Models\RatingPoint;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;

class AwardDurationAchievements implements ShouldQueue
{
    public function handle(RatingCreated $event)
    {
        $users = User::whereIn(
            'id',
            RatingPoint::where('date', $event->date)->select('user_id')->get()
        )->with('rating_points')->get();

        foreach ($users as $user) {
            $points = $user->rating_points()->select('date')->distinct('date')->count();

            $user->setProgress(new DurationChain(), $points);
        }
    }
}
