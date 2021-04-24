<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Rating\RatingPointCategoryIndexResource;
use App\Http\Resources\Rating\RatingPointsIndexResource;
use App\Models\RatingPoint;
use App\Models\RatingPointCategory;
use App\Services\RatingService;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public RatingService $ratingService;
    public function __construct(RatingService $ratingService)
    {
        $this->ratingService = $ratingService;
    }

    public function show(Request $request)
    {
        if ($request->has(['start', 'end'])) {
            $period = CarbonPeriod::since($request->get('start'))->until($request->get('end'));
        } else {
            $period = $this->ratingService->getLastPointsPeriod();
        }

        $points = $this->ratingService->getRating($period);

        return response()->json([
            'rating' => RatingPointsIndexResource::collection($points),
            'meta' => [
                'period' => [
                    'start' => $period->start->isoFormat('YYYY-MM'),
                    'end' => $period->end->isoFormat('YYYY-MM'),
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
