<?php

namespace App\Models;

use Carbon\CarbonPeriod;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RatingPoint extends Model
{
    use HasFactory;

    protected $casts = [
        'date' => 'datetime:Y-m',
    ];

    protected $dates = ['date', 'created_at', 'updated_at'];

    protected $fillable = ['rating_id', 'rating_point_category_id', 'amount'];

    protected function serializeDate(DateTimeInterface $date): string
    {
        return $date->format('Y-m');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(RatingPointCategory::class, 'rating_point_category_id');
    }

    public function scopeFromPeriod(Builder $builder, CarbonPeriod $period): Builder
    {
        return $builder->whereDate('date', '>=', $period->start)
            ->whereDate('date', '<=', $period->end);
    }
}
