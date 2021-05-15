<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Rating\RatingPointCategoryIndexResource;
use App\Http\Resources\Rating\RatingPointsIndexResource;
use App\Models\RatingPointCategory;
use App\Services\Rating\Rating;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function show(Request $request)
    {
        if ($request->has(['start', 'end'])) {
            $rating = (new Rating())->setPeriodStart($request->get('start'))
                ->setPeriodEnd($request->get('end'));
        } else {
            $rating = (new Rating())->last();
        }

        $points = $rating->get();
        $categories = RatingPointCategory::all();

        return response()->json([
            'rating' => RatingPointsIndexResource::collection($points),
            'categories' => RatingPointCategoryIndexResource::collection($categories),
            'meta' => [
                'period' => [
                    'start' => $rating->period->start->isoFormat('YYYY-MM'),
                    'end' => $rating->period->end->isoFormat('YYYY-MM'),
                ],
            ]
        ]);
    }
}
