<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Rating\RatingPointsIndexResource;
use App\Models\RatingPoint;
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

        return response()->json(
            RatingPointsIndexResource::collection($points->get()->groupBy('user_id'))
        );
    }
}
