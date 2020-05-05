<?php

namespace App;

use CyrildeWit\EloquentViewable\Contracts\Viewable;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;


/**
 * @mixin Builder
 */
class Article extends Model implements HasMedia, Viewable
{
    use HasMediaTrait, InteractsWithViews;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_likes');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getIsLikedAttribute() {
        return UserLike::where([['article_id', $this->id], ['user_id', Auth::user()->id]])->exists();
    }



    public function getUrlAttribute()
    {
        return route('article.show', $this);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class)->orderByDesc('created_at')->with('user');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'article_tags');
    }

    public function getRecentCommentCountAttribute() {
        return $this->comments()->where('created_at', '>', now()->subDays(3))->get()->count();
    }


//    scopes
    public function scopePublished()
    {
        return Article::where([['is_blank', false], ['is_published', true]]);
    }

    public function scopeNotPublished()
    {
        return Article::where([['is_blank', false], ['is_published', false]]);
    }

    public function scopeDraft()
    {
        return Article::where([['is_blank', true], ['is_published', true]]);
    }

    public function scopeBlank()
    {
        return Article::where([['is_blank', true], ['is_published', false]]);
    }
}
