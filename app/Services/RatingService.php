<?php

namespace App\Services;

use App\Models\RatingPoint;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

class RatingService
{
    public function getRating(CarbonPeriod $period): Collection
    {
        $points = RatingPoint::fromPeriod(
            $period
        )->with(['user', 'category'])->get()->groupBy(['user_id', 'rating_point_category_id']);

        $points = $this->mergeRatingPointsByCategories($points);

        return $points;
    }

    public function getLastPointsPeriod(): CarbonPeriod
    {
        $start = ($point = RatingPoint::orderBy('date', 'desc')->first()) ? $point->date : now();

        return CarbonPeriod::since($start)->until($start);
    }

    protected function mergeRatingPointsByCategories(Collection $ratingPoints): Collection
    {
        $ratingPoints = $ratingPoints->map(function (Collection $categories) {
            return $categories->map(function (Collection $categoryPoints, int $category_id) {
                return collect([
                    'user' => $categoryPoints->first()->user->only(['id', 'name', 'url']),
                    'rating_point_category_id' => $category_id,
                    'amount' => $categoryPoints->sum('amount'),
                ]);
            });
        });

        return $ratingPoints;
    }
}
