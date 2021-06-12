<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ArticleTag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'article_article_tag');
    }

    public function getArticlesCountAttribute(): int
    {
        return $this->articles()->count();
    }

    public function getUrlAttribute(): string
    {
        return route('articles.index', ['query' => $this->name]);
    }
}
