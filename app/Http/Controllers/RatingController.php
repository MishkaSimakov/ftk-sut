<?php

namespace App\Http\Controllers;

use App\Imports\RatingsImport;
use App\Point;
use App\Rating;
use App\User;
use App\Achievement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use function view;

class RatingController extends Controller
{
    public function index()
    {
        $ratings = Rating::all();

        return view('rating.index', compact('ratings'));
    }

    public function show(Rating $rating)
    {
        return view('rating.show', compact('rating'));
    }

    public function create()
    {
        return view('rating.create');
    }

    public function store(Request $request)
    {
        $rows = Excel::toCollection(new RatingsImport, request()->file('file'));


        $rating = Rating::make();

        $rating->isMonthly = boolval($request->type);

        if ($request->type) {
            $date = new Carbon($request->month);
        } else {
            $date = new Carbon($request->year);
        }

        $rating->date = $date;

        $rating->save();

        $flag = true;

        foreach ($rows[0] as $row) {
            if (is_null($row[0]) && is_null($row[2])) {
                break;
            }

            if ($flag == true) {
                $flag = false;

                continue;
            }

            $point = Point::make();

            $name = $row[0];

            if (!User::where('name', $name)->exists()) {
                $user = User::make();

                $user->name = $name;
                $user->register_code = rand(10000, 99999);

                $user->save();
            } else {
                $user = User::where('name', $name)->first();
            }

            $point->user_id = $user->id;
            $point->rating_id = $rating->id;

            if (is_null($row[2])) {
                $point->points_lessons = 0;
            } else {
                $point->points_lessons = $row[2];
            }

            if (is_null($row[3])) {
                $point->points_games = 0;
            } else {
                $point->points_games = $row[3];
            }

            if (is_null($row[4])) {
                $point->points_press = 0;
            } else {
                $point->points_press = $row[4];
            }

            if (is_null($row[5])) {
                $point->points_travels = 0;
            } else {
                $point->points_travels = $row[5];
            }

            if (is_null($row[6])) {
                $point->points_local_competition = 0;
            } else {
                $point->points_local_competition = $row[6];
            }

            if (is_null($row[7])) {
                $point->points_global_competition = 0;
            } else {
                $point->points_global_competition = $row[7];
            }

            $point->points = $point->points_global_competition +
                             $point->points_local_competition +
                             $point->points_travels +
                             $point->points_press +
                             $point->points_games +
                             $point->points_lessons;

            $point->place = 0;

            $point->save();
        }

        $points = $rating->points->sortByDesc('points');

        $index = 1;

        foreach ($points as $point) {
            $point->increment('place', $index);

            $index++;
        }

        //getting achievements
        $achievements = Achievement::all();

        $functions = '
            use App\UserAchievement;

            if (!function_exists("getAchievement")) {
                function getAchievement() {
                    global $point;
                    global $achievement;

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
                function setAchievementProgress($progress) {
                    global $point;
                    global $achievement;

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
                function incrementAchievementProgress($increment) {
                    global $point;
                    global $achievement;

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
        ';

        foreach ($points as $point) {
            $GLOBALS['point'] = $point;

            foreach ($achievements as $achievement) {
                $GLOBALS['achievement'] = $achievement;

                if (!GetUserAchievement($point->user, $achievement)) {
                    eval($functions . ' ' . $achievement->code);
                } else {
                    if (!GetUserAchievement($point->user, $achievement)->completed) {
                        eval($functions . ' ' . $achievement->code);
                    }
                }
            }
        }

        return redirect(route('rating.show', $rating));
    }
}