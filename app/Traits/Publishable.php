<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Publishable
{
    public function scopePublished(Builder $builder): Builder
    {
        return $builder->whereDate('date', '<=', now());
    }

    public function getIsPublishedAttribute(): bool
    {
        return $this->date <= now();
    }

    public function getIsNotPublishedAttribute(): bool
    {
        return !$this->getIsPublishedAttribute();
    }
}
