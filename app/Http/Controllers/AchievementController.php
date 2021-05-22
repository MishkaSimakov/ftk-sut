<?php

namespace App\Http\Controllers;

use App\Services\AchievementsService;

class AchievementController extends Controller
{
    public function index(AchievementsService $achievementsService)
    {
        $achievements = $achievementsService->getAll();

        if (auth()->check()) {
            $achievements = $achievementsService->orderByProgress($achievements);
        }

        return view('achievements.index', compact('achievements'));
    }
}
