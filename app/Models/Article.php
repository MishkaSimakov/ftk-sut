<?php

namespace App\Models;

use App\Traits\Publishable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model implements Viewable
{
    use HasFactory, InteractsWithViews, Publishable;

    const TRUNCATE_LIMIT = 500;
    const PAGINATION_LIMIT = 50;

    protected $dates = ['date'];
    protected $fillable = ['title', 'body', 'date'];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function points(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'article_points');
    }

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(ArticleTag::class, 'article_article_tag');
    }


    public function getUrlAttribute(): string
    {
        return route('article.show', $this);
    }

    public function isLikedBy(User $user): bool
    {
        return $this->points()->where('user_id', $user->id)->exists();
    }

    public function getTruncatedBodyAttribute(): string
    {
        return truncateHTML(self::TRUNCATE_LIMIT, strip_tags($this->body, ['p', 'b', 'i', 'ul', 'li', 'ol']));
    }

    public function getRelevanceAttribute(): int
    {
        return $this->points()->count() + views($this)->count() * 0.25 - now()->diffInDays($this->date) * 2;
    }
}
