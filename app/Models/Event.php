<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Storage;

class Event extends Model
{
    protected $fillable = [
        'name',
        'description',
        'date_start',
        'date_end',
        'image_url'
    ];

    protected $dates = [
        'date_end', 'date_start'
    ];

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function imageUrl(): string
    {
        return Storage::url($this->image_url);
    }

    public function scopePast(Builder $builder): Builder
    {
        return $builder->whereDate('date_end', '<=', now());
    }

    public function scopeFuture(Builder $builder): Builder
    {
        return $builder->whereDate('date_end', '>', now());
    }

    public function isPast(): bool
    {
        return $this->date_end->lessThanOrEqualTo(now());
    }

    public function isFuture(): bool
    {
        return !$this->isPast();
    }

    public function isUserSignedUp(User $user)
    {
        return $this->users()->where('id', $user->id)->exists();
    }
}
