<?php

namespace App\Http\Controllers\Api;

use App\PointCategory;
use App\Rating;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;

class RatingController extends Controller
{
    public function show(Rating $rating)
    {
        $students = $rating->students()->with([
            'user',
            'points' => function ($query) use ($rating) {
                $query->where('rating_id', $rating->id);
            },
            'points.category'
        ])->get();
        $categories = PointCategory::select('id', 'color', 'title')->get();

        $data = $students->map(function ($student) {
            return [
                'user' => $student->user,
                'total' => array_sum($student->points->pluck('amount')->toArray()),
                'points' => $student->points->map(function ($point) {
                    return [
                        'id' => $point->category->id,
                        'amount' => $point->amount,
                        'color' => $point->category->color,
                        'title' => $point->category->title
                    ];
                })
            ];
        });

        return response()->json([$categories, $data]);
    }
}
