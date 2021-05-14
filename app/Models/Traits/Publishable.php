<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;

trait Publishable
{
    public function scopePublished(Builder $builder): Builder
    {
        return $builder->whereDate('date', '<=', now());
    }

    public function getIsPublishedAttribute(): bool
    {
        return $this->date->isPast();
    }

    public function getIsNotPublishedAttribute(): bool
    {
        return !$this->getIsPublishedAttribute();
    }
}
