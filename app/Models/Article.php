<?php

namespace App\Models;

use App\Enums\ArticleType;
use App\Events\Article\ArticleFirstTimeChecked;
use App\Events\Article\ArticleLiked;
use App\Models\Traits\Checkable;
use App\Models\Traits\Publishable;
use App\Notifications\NewUncheckedArticleNotification;
use App\Scoping\Traits\CanBeScoped;
use App\Services\ArticleBodyPrepareService;
use BenSampo\Enum\Traits\CastsEnums;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Article extends Model implements Viewable
{
    use HasFactory;
    use InteractsWithViews;
    use Publishable;
    use CastsEnums;
    use CanBeScoped;
    use Checkable;

    const TRUNCATE_LIMIT = 500;
    const PAGINATION_LIMIT = 10;

    const MAX_DRAFTS_COUNT = 100;

    const RELEVANCE_COEFFICIENTS = [
        'points' => 1,
        'views' => 0.1,
        'days' => -0.06
    ];

    protected $dates = ['date'];
    protected $fillable = ['title', 'body', 'date', 'type', 'author_id', 'checked_at'];
    protected bool $removeViewsOnDelete = true;

    protected $casts = [
        'type' => ArticleType::class
    ];

    protected static function boot()
    {
        parent::boot();

        self::deleting(function (Article $article) {
            (new ArticleBodyPrepareService())->deleteSavedArticleImages($article);
        });

        self::saved(function (Article $article) {
            if ($article->type->is(ArticleType::OnCheck)) {
                (new NewUncheckedArticleNotification($article))->notify();
            }
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
        return route('articles.show', $this);
    }

    public function getTruncatedBodyAttribute(): string
    {
        return truncateHTML(self::TRUNCATE_LIMIT, strip_tags($this->body, ['p', 'b', 'i', 'ul', 'li', 'ol']));
    }

    public function scopeOrderByRelevance(Builder $builder): Builder
    {
        $sql = '`points_count` * ' . Article::RELEVANCE_COEFFICIENTS['points'] . ' + `views_count` * ' . Article::RELEVANCE_COEFFICIENTS['views'] . ' + datediff(now(), `date`) * ' . Article::RELEVANCE_COEFFICIENTS['days'] . ' DESC';

        return $builder->orderByRaw($sql, 'desc');
    }

    protected function getCheckedStateEnum()
    {
        return ArticleType::Checked;
    }

    protected function getUncheckedStateEnum()
    {
        return ArticleType::OnCheck;
    }

    protected function checkedEvent(bool $isFirstTimeChecked)
    {
        ArticleFirstTimeChecked::dispatchIf($isFirstTimeChecked, $this);
    }

    /* Эта функция показывает, отображается ли статья у всех пользователей */
    public function isAvailable(): bool
    {
        return $this->is_published and $this->type->is(ArticleType::Checked);
    }

    public function scopeDrafts(Builder $builder): Builder
    {
        return $builder->where('type', ArticleType::Draft);
    }


    public function toggleLikeBy(User $user)
    {
        $this->points()->toggle($user);

        ArticleLiked::dispatch($this, $user);
    }

    public function isLikedBy(User $user): bool
    {
        return $this->loadMissing('points')->points->contains('id', $user->id);
    }


    public function attachTagsFromString(?string $tags)
    {
        if (!$tags) {
            return;
        }

        foreach (json_decode($tags) as $tag) {
            $tag_id = ArticleTag::firstOrCreate(['name' => $tag->value]);

            $this->tags()->syncWithoutDetaching($tag_id);
        }
    }

    public function storeImagesFromBody()
    {
        $this->update([
            'body' => (new ArticleBodyPrepareService())->getPreparedBody($this)
        ]);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(ArticleComment::class);
    }
}
