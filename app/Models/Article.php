<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;

    const TRUNCATE_LIMIT = 500;
    const PAGINATION_LIMIT = 50;

    protected $dates = ['date'];

    public function author()
    {
        return $this->belongsTo(User::class);
    }

    public function points()
    {
        return $this->hasMany(ArticlePoint::class);
    }

    public function tags()
    {
        return $this->belongsToMany(ArticleTag::class, 'article_article_tag');
    }


    public function getUrlAttribute()
    {
        return route('article.show', $this);
    }

    public function getTruncatedBodyAttribute(): string
    {
        return truncateHTML(self::TRUNCATE_LIMIT, strip_tags($this->body, ['p', 'b', 'i', 'ul', 'li', 'ol']));
    }

    public function getPointsCountAttribute()
    {
        return $this->points->count();
    }

    public function getViewsAttribute()
    {
        return 0; // TODO: сделать подсчёт просмотров.
    }

    public function getRelevanceAttribute()
    {
        return $this->pointsCount + $this->views * 0.25 - now()->diffInDays($this->date) * 2;
    }

    public function scopeSearch(Builder $builder, string $query)
    {
        return $builder->where('title', 'like', "%{$query}%")
            ->orWhere('body', 'like', "%{$query}%");
    }
}
