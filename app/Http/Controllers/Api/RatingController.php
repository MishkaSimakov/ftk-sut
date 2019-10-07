<?php

namespace App\Http\Controllers\Api;

use App\Category;
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
        $points = Rating::where('date', $request->date)->first()->points->take(5)->sortByDesc('points');
        $categories = Category::all();

        $chartData = [];

        foreach ($points as $point) {
            array_push($chartData, [
                'us|' . $point->user->id . '|' . $point->user->name,

                $point->user->getAmount($point->rating, 'lessons'),
                'stroke-width: 1; stroke-color: black;',
                $point->user->getAmount($point->rating, 'games'),
                'stroke-width: 1; stroke-color: black;',
                $point->user->getAmount($point->rating, 'press'),
                'stroke-width: 1; stroke-color: black;',
                $point->user->getAmount($point->rating, 'travels'),
                'stroke-width: 1; stroke-color: black;',
                $point->user->getAmount($point->rating, 'local_competitions'),
                'stroke-width: 1; stroke-color: black;',
                $point->user->getAmount($point->rating, 'global_competitions'),
                'stroke-width: 1; stroke-color: black;',

                $point->user->totalPoints($point->rating),
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
