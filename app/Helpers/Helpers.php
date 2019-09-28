<?php

use App\User;
use App\Achievement;
use App\UserAchievement;
use Carbon\Carbon;
use App\Point;

if (!function_exists('getUserAchievement')) {
    function getUserAchievement(User $user, Achievement $achievement)
    {
        return UserAchievement::where([['user_id', $user->id], ['achievement_id', $achievement->id]])->first();
    }
}

if (!function_exists('getRussianMonth')) {
    function getRussianMonth(Carbon $date, $isGenitive = false)
    {
    	$month = ['Январь', 'Февраль', 'Март', 'Арпель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'];

    	$genetiveMonth = ['Января', 'Февраля', 'Марта', 'Арпеля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];

    	if ($isGenitive) {
    		return $genetiveMonth[$date->month - 1];
    	}

    	return $month[$date->month - 1];
    }
}

if (!function_exists('getRussianWeekday')) {
    function getRussianWeekday(Carbon $date)
    {
    	$weekday = ['Воскресенье', 'Понедельник', 'Вторник', 'Среда', 'Четверг', 'Пятница', 'Суббота'];

    	return $weekday[$date->dayOfWeek];
    }
}

if (!function_exists('compare')) {
    function compare($compare_code, $compare_number) {
        $compare_symbol = explode('|', $compare_code)[0];
        $first_number = $compare_number;
        $second_number = explode('|', $compare_code)[1];

        switch ($compare_symbol) {
            case '>':
                return $first_number > $second_number;

                break;
            case '<':
                return $first_number < $second_number;

                break;
            case '!=':
                return $first_number != $second_number;

                break;
            case '<=':
                return $first_number <= $second_number;

                break;
            case '>=':
                return $first_number >= $second_number;

                break;
            case '=':
                return $first_number == $second_number;

                break;
        }

        return false;
    }
}


if (!function_exists("getAchievement")) {
    function getAchievement(Point $point, Achievement $achievement) {
        if (GetUserAchievement($point->user, $achievement)) {
            GetUserAchievement($point->user, $achievement)->update(["completed" => true]);
        } else {
            $user_achievement = UserAchievement::make();

            $user_achievement->user_id = $point->user->id;
            $user_achievement->achievement_id = $achievement->id;
            $user_achievement->completed = true;

            $user_achievement->save();
        }
    }
}

if (!function_exists("setAchievementProgress")) {
    function setAchievementProgress($progress, Point $point, Achievement $achievement) {
        if (GetUserAchievement($point->user, $achievement)) {
            GetUserAchievement($point->user, $achievement)->update(["progress", $progress]);
        } else {
            $user_achievement = UserAchievement::make();

            $user_achievement->user_id = $point->user->id;
            $user_achievement->achievement_id = $achievement->id;
            $user_achievement->progress = $progress;

            $user_achievement->save();
        }
    }
}

if (!function_exists("incrementAchievementProgress")) {
    function incrementAchievementProgress($increment, Point $point, Achievement $achievement) {
        if (GetUserAchievement($point->user, $achievement)) {
            GetUserAchievement($point->user, $achievement)->increment("progress", $increment);
        } else {
            $user_achievement = UserAchievement::make();

            $user_achievement->user_id = $point->user->id;
            $user_achievement->achievement_id = $achievement->id;
            $user_achievement->progress = $increment;

            $user_achievement->save();
        }
    }
}
