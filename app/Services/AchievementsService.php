<?php

namespace App\Services;

use App\Models\User;
use Assada\Achievements\Model\AchievementDetails;
use Assada\Achievements\Model\AchievementProgress;
use Illuminate\Support\Collection;

class AchievementsService
{
    public function getAll(): Collection
    {
        return AchievementDetails::with(['progress'])->get();
    }

    public function orderByProgress(Collection $achievements): Collection
    {
        return $achievements->sortByDesc(function (AchievementDetails $details) {
            return optional($this->getUserProgressFromDetails(auth()->user(), $details))->points / $details->points;
        });
    }

    protected function getUserProgressFromDetails(User $user, AchievementDetails $details): ?AchievementProgress
    {
        return $details->progress()->where('achiever_id', $user->id)
            ->where('achiever_type', User::class)
            ->first();
    }
}
