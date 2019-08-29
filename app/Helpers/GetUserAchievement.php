<?php

use App\User;
use App\Achievement;
use App\UserAchievement;

if (!function_exists('getUserAchievement')) {
    function getUserAchievement(User $user, Achievement $achievement)
    {
        return UserAchievement::where([['user_id', $user->id], ['achievement_id', $achievement->id]])->first();
    }
}