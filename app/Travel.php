<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Travel extends Model
{
    protected $fillable = ['schedule_id', 'distance', 'is_bike'];

    public function schedule() {
        return $this->belongsTo(Schedule::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'travel_users')->withPivot('distance');
    }

    public function scopeSeason(Builder $builder, $season)
    {
        return $builder->whereHas('schedule', function ($q) use ($season) {
            if ($season === 0) {
                return $q->whereMonth('date_start', 12)->orWhereMonth('date_start', 1)->orWhereMonth('date_start', 2);
            } elseif ($season === 1) {
                return $q->whereMonth('date_start', 3)->orWhereMonth('date_start', 4)->orWhereMonth('date_start', 5);
            } else {
                return $q->whereMonth('date_start', 9)->orWhereMonth('date_start', 10)->orWhereMonth('date_start', 11);
            }
        });
    }

    public function getDateAttribute()
    {
        return optional($this->schedule)->date_start;
    }

    public function getAcademicYearAttribute()
    {
        if ($this->date->month < 9) {
            return ($this->date->year - 1) . '-' . $this->date->year;
        } else {
            return $this->date->year . '-' . ($this->date->year + 1);
        }
    }

    public function scopeBike(Builder $builder)
    {
        return $builder->where('is_bike', true);
    }

    public function scopeHiking(Builder $builder)
    {
        return $builder->where('is_bike', false);
    }

    public function scopeAcademicYear(Builder $builder, array $years)
    {
        return $builder->whereHas('schedule', function ($q) use ($years) {
            $q
                ->where(function ($q) use ($years) {
                    $q->whereYear('date_start', $years[0])->whereMonth('date_start', '>=', '9');
                })->orWhere(function ($q) use ($years) {
                    $q->whereYear('date_start', $years[1])->whereMonth('date_start', '<', '9');
                });
        });
    }
}
