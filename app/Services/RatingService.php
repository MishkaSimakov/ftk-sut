<?php

namespace App\Services;

use App\Events\RatingCreated;
use App\Imports\RatingImport;
use App\Models\RatingPoint;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use DB;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;

class RatingService
{
    public function getRatingFromPeriod(CarbonPeriod $period): Collection
    {
        return RatingPoint::fromPeriod($period)->select([
            'id',
            'rating_point_category_id',
            'user_id',
            DB::raw('SUM(amount) as amount')
        ])->groupBy('user_id', 'rating_point_category_id')->with(['user', 'category'])
            ->get()->groupBy('user_id');
    }

    public function storeRating(Carbon $date, UploadedFile $rating)
    {
        Excel::import(new RatingImport($date), $rating);

        RatingCreated::dispatch($date);
    }

    public function getLastPointsPeriod(): CarbonPeriod
    {
        $start = ($point = RatingPoint::orderBy('date', 'desc')->first()) ? $point->date : now();

        return CarbonPeriod::since($start)->until($start);
    }
}
