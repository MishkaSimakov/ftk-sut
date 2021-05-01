<?php

namespace App\Http\Controllers\Statistics;

use App\Http\Controllers\Controller;
use App\Models\RatingPoint;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

class RatingPointsStatisticsController extends Controller
{
    public function getPointsByCategories(User $user): Collection
    {
        return RatingPoint::where('user_id', $user->id)
            ->selectRaw('sum(amount) as amount, rating_point_category_id')
            ->groupBy('rating_point_category_id')->with('category')->get()
            ->sortBy('category.order')->values();
    }

    public function getPointsByMonth(User $user): Collection
    {
        return RatingPoint::where('user_id', $user->id)
            ->selectRaw('sum(amount) as amount, date')
            ->groupBy('date')->orderBy('date')->get();
    }

    public function getShortPointsStatistics(User $user): JsonResponse
    {
        return response()->json([
            'pointsByMonth' => $this->getPointsByMonth($user),
            'pointsByCategories' => $this->getPointsByCategories($user)
        ]);
    }
}
