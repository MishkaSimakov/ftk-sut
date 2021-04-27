<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Models\RatingPoint;
use App\Models\User;
use App\Services\RatingService;
use Illuminate\Http\JsonResponse;

class RatingPointsStatisticsController extends Controller
{
    public function getPointsByMonth(User $user): JsonResponse
    {
        $ratingPoints = RatingPoint::where('user_id', $user->id)->selectRaw('sum(amount) as amount, date')->groupBy('date')->orderBy('date')->get();

        return response()->json($ratingPoints);
    }
}
