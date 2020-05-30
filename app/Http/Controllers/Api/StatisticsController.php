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
        $ratings = Rating::where('type', 'monthly')->get()->sortByDesc('date')->load('points');

        $labels = [];
        $values = [];

        foreach ($ratings as $rating) {
            $points = $rating->points()->where('student_id', optional($user->student)->id)->get();

            if ($points->count() != 0) {
                array_push($labels, $rating->date->locale('ru')->isoFormat('MMMM YYYY'));
                array_push($values, $points->sum('amount'));
            }
        }

        return response()->json([$labels, $values]);
    }

    public function categories(User $user) {
        $values = $user->student->points()
            ->WhereHas('rating', function ($q) {
            $q->where('type', 'monthly');
        })->get()->groupBy('category_id')->map(function ($category) {
            return $category->pluck('amount')->sum();
        });
        $categories = $values->map(function ($value, $index) {
            return PointCategory::where('id', $index)->select('color', 'title')->first();
        })->toArray();

        return response()->json([$categories, $values]);
    }
}
