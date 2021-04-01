<?php

namespace App\Models;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model implements Viewable
{
    use HasFactory, InteractsWithViews;

    protected $fillable = ['title', 'date', 'body'];
    protected $dates = ['date'];
    protected $removeViewsOnDelete = true;

    const PAGINATION_LIMIT = 50;

    public function clubs()
    {
        return $this->belongsToMany(Club::class, 'news_club');
    }

    public function scopeClub(Builder $builder, $club)
    {
        if ($club instanceof Club) {
            $club = $club->name;
        }

        return $builder->whereHas('clubs', function (Builder $builder) use ($club) {
            $builder->where('name', $club);
        });
    }

    public function scopePublished(Builder $builder)
    {
        return $builder->whereDate('date', '<=', now());
    }

    public function getViewsAttribute()
    {
        return views($this)->unique()->count();
    }

    public function recordView()
    {
        if (!$this->date->greaterThan(now())) {
            views($this)->cooldown(now()->addHours(3))->record();
        }
    }
}
