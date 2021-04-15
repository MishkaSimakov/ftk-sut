<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleTag extends Model
{
    use HasFactory;

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_article_tag');
    }

    public function scopeSearch(Builder $builder, string $query)
    {
        return $builder->where('name', 'like', "%{$query}%");
    }
}
