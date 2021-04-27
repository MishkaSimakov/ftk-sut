<?php

namespace App\Models;

use App\Traits\Publishable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model implements Viewable
{
    use HasFactory, InteractsWithViews, Publishable;

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
}
