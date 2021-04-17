<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Publishable
{
    public function scopePublished(Builder $builder)
    {
        return $builder->whereDate('date', '<=', now());
    }

    public function getIsPublishedAttribute()
    {
        return $this->date <= now();
    }
}
