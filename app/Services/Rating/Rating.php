<?php


namespace App\Services\Rating;


use App\Events\RatingCreated;
use App\Imports\RatingImport;
use App\Models\RatingPoint;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class Rating
{
    public CarbonPeriod $period;
    public User $user;

    public function setPeriod(CarbonPeriod $period): self
    {
        $this->period = $period;

        return $this;
    }

    public function setPeriodStart(Carbon $start): self
    {
        $this->period->setStartDate($start);

        return $this;
    }

    public function setPeriodEnd(Carbon $end): self
    {
        $this->period->setEndDate($end);

        return $this;
    }

    public function last(): self
    {
        $this->period = $this->getLastPointsPeriod();

        return $this;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function get(): Collection
    {
        $query = RatingPoint::query();

        if ($this->period) {
            $query = $query->fromPeriod($this->period);
        }

        return $query->select([
            'id',
            'rating_point_category_id',
            'user_id',
            DB::raw('SUM(amount) as amount')
        ])->groupBy('user_id', 'rating_point_category_id')->with(['user', 'category'])
            ->get()->groupBy('user_id');
    }

    public function store(Carbon $date, UploadedFile $rating)
    {
        Excel::import(new RatingImport($date), $rating);

        RatingCreated::dispatch($date);
    }


    protected function getLastPointsPeriod(): CarbonPeriod
    {
        $start = ($point = RatingPoint::orderBy('date', 'desc')->first()) ? $point->date : now();

        return CarbonPeriod::since($start)->until($start);
    }
}
