<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\AchievementsService;

class AchievementController extends Controller
{
    public function index(User $user, AchievementsService $achievementsService)
    {
        $achievements = $achievementsService->getAll();

        return view('users.achievements', compact('achievements', 'user'));
    }
}
