<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;
use Spatie\MediaLibrary\HasMedia\HasMedia;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;

class Article extends Model implements HasMedia
{
    use HasMediaTrait;

    //

    protected $guarded = [];

    public function getPublishUrlAttribute() {
    	return route('article.publish', $this);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_likes');
    }

    public function getDeleteUrlAttribute() {
    	return route('article.destroy', $this);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getIsLikedAttribute() {
        return UserLike::where([['article_id', $this->id], ['user_id', Auth::user()->id]])->exists();
    }

    static function notPublished() {
        return Article::where('is_blank', false)->where('is_published', false)->orWhere('is_published', null)->get();
    }

    public function getUrlAttribute()
    {
        return route('article.show', $this);
    }
}
