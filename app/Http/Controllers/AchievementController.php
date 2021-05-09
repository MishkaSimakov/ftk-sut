<?php

namespace App\Http\Controllers;

use Assada\Achievements\Achievement;
use Assada\Achievements\Model\AchievementDetails;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::all();

        if (auth()->check()) {
            $achievements = $achievements->sortByDesc(function (AchievementDetails $achievement) {
                return auth()->user()->achievementStatus($achievement->getClass())->points / $achievement->points;
            });
        }

        return view('achievements.index', compact('achievements'));
    }
}
