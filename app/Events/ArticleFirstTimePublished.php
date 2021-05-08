<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Foundation\Events\Dispatchable;

class ArticleFirstTimePublished
{
    use Dispatchable;

    public Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }
}
