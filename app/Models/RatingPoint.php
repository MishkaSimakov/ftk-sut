<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RatingPoint extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'datetime:Y-m',
    ];

    protected $dates = ['date', 'created_at', 'updated_at'];

    protected $fillable = ['rating_id', 'rating_point_category_id', 'amount'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(RatingPointCategory::class, 'rating_point_category_id');
    }

    public function scopeFromTime(Builder $builder, Carbon $start, Carbon $end)
    {
        return $builder->whereDate('date', '>=', $start)
            ->whereDate('date', '<=', $end);
    }

    public function scopeLastPoints(Builder $builder)
    {
        $last_date = RatingPoint::orderBy('date', 'desc')->first()->date;

        return $builder->fromTime($last_date);
    }
}
