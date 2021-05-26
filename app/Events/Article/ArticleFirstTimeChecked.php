<?php

namespace App\Events\Article;

use App\Models\Article;
use Illuminate\Foundation\Events\Dispatchable;

class ArticleFirstTimeChecked
{
    use Dispatchable;

    public Article $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }
}
