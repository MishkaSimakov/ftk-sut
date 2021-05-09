<?php

namespace App\Listeners\RatingPoints;

use App\Achievements\Chains\RatingPointChain;
use App\Events\RatingCreated;
use App\Models\User;
use App\Services\RatingService;
use Illuminate\Contracts\Queue\ShouldQueue;

class AwardRatingPointAchievements implements ShouldQueue
{
    public function handle(RatingCreated $event)
    {
        $rating = (new RatingService())->getRatingFromPeriod($event->date->toPeriod($event->date));
        $users = User::all();

        foreach ($rating as $user_id => $categories) {
            $users->find($user_id)->setProgress(new RatingPointChain(), $categories->sum('amount'));
        }
    }
}
