<?php

namespace App\Listeners\RatingPoints;

use App\Achievements\Chains\RatingPointChain;
use App\Achievements\Rating\Monthly\TakeFirstPlace;
use App\Achievements\Rating\Monthly\TakeSecondPlace;
use App\Achievements\Rating\Monthly\TakeThirdPlace;
use App\Events\RatingCreated;
use App\Models\User;
use App\Services\RatingService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

class AwardMonthlyRatingPointAchievements implements ShouldQueue
{
    public function handle(RatingCreated $event)
    {
        $rating = (new RatingService())->getRatingFromPeriod($event->date->toPeriod($event->date))
            ->sortByDesc(function (Collection $categories) {
                return $categories->sum('amount');
            });
        $users = User::all();

        $place = 1;

        foreach ($rating as $user_id => $categories) {
            $user = $users->find($user_id);

            $this->awardRatingPointAchievementsForUser(
                $user,
                $categories
            );

            $this->awardPlaceAchievement(
                $user,
                $place
            );

            $place++;
        }
    }

    protected function awardRatingPointAchievementsForUser(User $user, Collection $categories)
    {
        $current_sum = $categories->sum('amount');

        if (
            $current_sum > 0 and
            $user->achievementStatus(Arr::last((new RatingPointChain())->chain()))->points < $current_sum
        ) {
            $user->setProgress(new RatingPointChain(), $current_sum);
        }
    }

    protected function awardPlaceAchievement(User $user, int $place)
    {
        if ($place > 3) {
            return;
        }

        $place_achievements = [
            new TakeFirstPlace(),
            new TakeSecondPlace(),
            new TakeThirdPlace(),
        ];

        $user->unlock($place_achievements[$place - 1]);
    }
}
