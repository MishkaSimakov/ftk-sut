<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_tags');
    }

    public function getArticleCountAttribute()
    {
        return $this->articles()->where([['is_blank', false], ['is_published', true]])->count();
    }
}