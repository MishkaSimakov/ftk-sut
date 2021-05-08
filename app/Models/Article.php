<?php

namespace App\Models;

use App\Achievements\WriteArticleChain;
use App\Models\Traits\Publishable;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Article extends Model implements Viewable
{
    use HasFactory, InteractsWithViews, Publishable;

    const TRUNCATE_LIMIT = 500;
    const PAGINATION_LIMIT = 10;

    const RELEVANCE_COEFFICIENTS = [
        'points' => 1,
        'views' => 0.25,
        'days' => -2
    ];

    protected $dates = ['date'];
    protected $fillable = ['title', 'body', 'date'];

    protected static function boot()
    {
        parent::boot();

        self::saved(function (Article $article) {
            $article->author->addProgress(new WriteArticleChain());
        });
    }

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
        return $this->loadMissing('points')->points->contains('id', $user->id);
    }

    public function getTruncatedBodyAttribute(): string
    {
        return truncateHTML(self::TRUNCATE_LIMIT, strip_tags($this->body, ['p', 'b', 'i', 'ul', 'li', 'ol']));
    }

    public function getRelevanceAttribute(): int
    {
        return $this->points()->count() * self::RELEVANCE_COEFFICIENTS['points']
            + views($this)->count() * self::RELEVANCE_COEFFICIENTS['views']
            + now()->diffInDays($this->date) * self::RELEVANCE_COEFFICIENTS['days'];
    }
}
