<?php

namespace App\Services;

use App\Models\RatingPoint;
use Carbon\CarbonPeriod;
use DB;
use Illuminate\Support\Collection;

class RatingService
{
    public function getRating(CarbonPeriod $period): Collection
    {
        return RatingPoint::fromPeriod($period)->select([
            'id',
            'rating_point_category_id',
            'user_id',
            DB::raw('SUM(amount) as amount')
        ])->groupBy('user_id', 'rating_point_category_id')->with(['user', 'category'])
            ->get()->groupBy('user_id');
    }

    public function getLastPointsPeriod(): CarbonPeriod
    {
        $start = ($point = RatingPoint::orderBy('date', 'desc')->first()) ? $point->date : now();

        return CarbonPeriod::since($start)->until($start);
    }
}
