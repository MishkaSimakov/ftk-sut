<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Rating\RatingPointCategoryIndexResource;
use App\Http\Resources\Rating\RatingPointsIndexResource;
use App\Models\RatingPoint;
use App\Models\RatingPointCategory;
use Carbon\Carbon;

class RatingController extends Controller
{
    public function show($period = null)
    {
        if ($period) {
            $period = preg_split('/([.\-])/', $period);

            $start = Carbon::create($period[0], $period[1]);
            $end = Carbon::create($period[2], $period[3]);
        } else {
            $start = RatingPoint::orderBy('date', 'desc')->first()->date;

            $end = $start;
        }

        $points = RatingPoint::fromTime(
            $start, $end
        )->with(['user', 'category'])->get()->groupBy('user_id');

        return response()->json([
            'rating' => RatingPointsIndexResource::collection($points),

            'categories' => RatingPointCategoryIndexResource::collection(
                RatingPointCategory::all()
            ),
            'meta' => [
                'period' => [
                    'start' => $start->isoFormat('YYYY-MM'),
                    'end' => $end->isoFormat('YYYY-MM'),
                ],
            ]
        ]);
    }
}
