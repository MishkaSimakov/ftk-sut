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
    public function index(Request $request)
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

        $rating->date = new Carbon($request->date);

        if (Rating::whereDate('date', $rating->date)->exists()) {
            return redirect()->back()->with('date', 'рейтинг с такой датой уже существует!');
        }

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

            $name = $row[0];

            if (!User::where('name', $name)->exists()) {
                $user = User::make();

                $user->name = $name;
                $user->register_code = rand(10000, 99999);

                $user->save();
            } else {
                $user = User::where('name', $name)->first();
            }

            $user->award($rating, 'lessons', $row[2]);
            $user->award($rating, 'games', $row[3]);
            $user->award($rating, 'press', $row[4]);
            $user->award($rating, 'travels', $row[5]);
            $user->award($rating, 'local_competitions', $row[6]);
            $user->award($rating, 'global_competitions', $row[7]);
        }

        $points = $rating->points->sortByDesc('points');

        //getting achievements
        $achievements = Achievement::all();

        foreach ($points as $point) {
            foreach ($achievements->where('category', 'monthly_rating') as $achievement) {
                if (GetUserAchievement($point->user, $achievement)) {
                    if (GetUserAchievement($point->user, $achievement)->completed) {
                        continue;
                    }
                }

                if (compare($achievement->condition, $point->points)) {
                    getAchievement($point, $achievement);
                } else {
                    setAchievementProgress($point->points, $point, $achievement);
                }
            }
        }

        return redirect(route('rating.show', $rating));
    }
}
