<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Rating\RatingPointCategoryIndexResource;
use App\Http\Resources\Rating\RatingPointsIndexResource;
use App\Models\RatingPoint;
use App\Models\RatingPointCategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function show($period = null)
    {
        if ($period) {
            $period = preg_split('/(\.|\-)/', $period);

            $points = RatingPoint::fromTime(
                Carbon::create($period[0], $period[1]),
                Carbon::create($period[2], $period[3])
            );
        } else {
            $points = RatingPoint::lastPoints();
        }

        return response()->json([
            'rating' => RatingPointsIndexResource::collection(
                $points->with(['user', 'category'])->get()->groupBy('user_id')
            ),
            'categories' => RatingPointCategoryIndexResource::collection(
                RatingPointCategory::all()
            ),
            'meta' => [
                'period' => [
//                    'start' =>
                ],
            ]
        ]);
    }
}
