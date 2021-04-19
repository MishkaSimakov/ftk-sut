<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Rating\RatingPointCategoryIndexResource;
use App\Http\Resources\Rating\RatingPointsIndexResource;
use App\Models\RatingPoint;
use App\Models\RatingPointCategory;
use App\Traits\InteractsWithRating;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function show(Request $request)
    {
        if ($request->has(['start', 'end'])) {
            $start = Carbon::create(
                explode('-', $request->get('start'))[0],
                explode('-', $request->get('start'))[1]
            );
            $end = Carbon::create(
                explode('-', $request->get('end'))[0],
                explode('-', $request->get('end'))[1]
            );
        } else {
            $start = ($point = RatingPoint::orderBy('date', 'desc')->first()) ? $point->date : now();
            $end = $start;
        }

        $points = RatingPoint::fromTime(
            $start, $end
        )->with(['user', 'category'])->get()->groupBy('user_id');

        return response()->json([
            'rating' => RatingPointsIndexResource::collection($points),
            'meta' => [
                'period' => [
                    'start' => $start->isoFormat('YYYY-MM'),
                    'end' => $end->isoFormat('YYYY-MM'),
                ],
            ]
        ]);
    }

    public function categories()
    {
        $categories = RatingPointCategory::all();

        return response()->json(
            RatingPointCategoryIndexResource::collection($categories)
        );
    }
}
