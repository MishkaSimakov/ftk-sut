<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Point;
use App\PointCategory;
use App\Rating;
use App\User;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function points(User $user) {
        $ratings = Rating::all()->sortByDesc('date')->load('points');

        $labels = [];
        $values = [];

        foreach ($ratings as $rating) {
            $points = $rating->points()->where('student_id', optional($user->student)->id)->get();

            if ($points->count() != 0) {
                array_push($labels, $rating->date->locale('ru')->isoFormat('MMMM YYYY'));
                array_push($values, $points->sum('amount'));
            }
        }

        return json_encode([$labels, $values]);
    }

    public function categories(User $user) {
        $ratings = Rating::all()->load('points.category');

        $labels = [];
        $values = [];

        foreach ($ratings as $rating) {
            $points = $rating->points()->where('student_id', optional($user->student)->id)->get()->sortBy('category_id');

            if ($points->count() != 0) {
                foreach ($points as $point) {
                    if (!in_array($point->category->title, $labels)) {
                        array_push($labels, $point->category->title);
                    }

                    $values[array_search($point->category->title, $labels)][] = $point->amount;
                }
            }
        }

        foreach ($values as $key => $value) {
            $values[$key] = array_sum($value);
        }

        return json_encode([$labels, $values]);
    }
}
