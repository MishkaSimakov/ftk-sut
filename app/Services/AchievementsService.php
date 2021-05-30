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
        return AchievementDetails::with(['progress', 'progress.details'])->get();
    }
}
