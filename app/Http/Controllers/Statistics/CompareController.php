<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Models\RatingPoint;
use App\Models\User;

class CompareController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('index');
    }

    public function index(User $user)
    {
        return view('statistics.compare', [
            'first' => $user,
            'second' => auth()->user()
        ]);
    }

    public function getCompareData(User $first, User $second)
    {
        $points = RatingPoint::whereIn('user_id', [$first->id, $second->id])
            ->selectRaw('sum(amount) as amount, date, user_id')
            ->groupBy('user_id', 'date')->orderBy('date')->get()->groupBy('user_id');

        $categories = RatingPoint::whereIn('user_id', [$first->id, $second->id])
            ->selectRaw('sum(amount) as amount, rating_point_category_id, user_id')
            ->groupBy('user_id', 'rating_point_category_id')->with('category')->get()
            ->sortBy('category.order')->groupBy('rating_point_category_id');

        $categories = $categories->map(function ($category) {
            return [
                'category' => $category[0]->category,
                'data' => $category->keyBy('user_id')->map->amount
            ];
        })->values();

        return response()->json([
            'points' => $points,
            'categories' => $categories,
            'names' => [
                $first->id => $first->name,
                $second->id => $second->name
            ]
        ]);
    }
}
