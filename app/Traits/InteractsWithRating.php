<?php

namespace App\Traits;

use App\Models\RatingPoint;
use App\Models\User;
use Carbon\CarbonPeriod;
use Illuminate\Support\Collection;

trait InteractsWithRating
{
    public function getRating(CarbonPeriod $period = null) : Collection
    {
        $points = RatingPoint::with(['user', 'category']);

        if (!is_null($period)) {
            $points = $points->whereBetween('date', [
                $period->start, $period->end
            ]);
        }

        $points = $points->get()->groupBy('user_id')->map(function ($points) {
            return $this->mapUserPoints($points);
        });

        return $points;
    }

    public function mapUserPoints(Collection $points) : Collection
    {
        return $points->groupBy('rating_point_category_id');
    }

    public function getUserPointsByCategory(User $user, Collection $points, CarbonPeriod $period = null)
    {

    }
}
