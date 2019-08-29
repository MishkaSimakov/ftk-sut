<?php

namespace App\Http\Controllers\Api;

use App\Rating;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function MongoDB\BSON\toJSON;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function chart(Request $request)
    {
        $points = Rating::where('date', $request->date)->first()->points->sortByDesc('points');
 
        $chartData = [];

        foreach ($points as $point) {

            array_push($chartData, [
                'us|' . $point->user->id . '|' . $point->user->name,
                
                $point->points_lessons,
                'stroke-width: 1; stroke-color: black;',

                $point->points_games,
                'stroke-width: 1; stroke-color: black;',

                $point->points_press,
                'stroke-width: 1; stroke-color: black;',

                $point->points_travels,
                'stroke-width: 1; stroke-color: black;',

                $point->points_local_competition,
                'stroke-width: 1; stroke-color: black;',

                $point->points_global_competition,
                'stroke-width: 1; stroke-color: black;',

                $point->points,
            ]);
        }

        return json_encode($chartData);
    }

    public function userStatistic(Request $request)
    {
        $points = User::where('id', $request->user)->first()->points;
 
        $chartData = [];

        foreach ($points as $point) {
            if ($point->rating->isMonthly) {
                array_push($chartData, [
                    intval($point->rating->date->format('U')),
                    $point->place
                ]);
            }
        }

        return json_encode($chartData);
    }
}
