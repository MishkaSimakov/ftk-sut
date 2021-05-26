<?php

namespace App\Events\Article;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class ArticleLiked
{
    use Dispatchable;

    public Article $article;
    public User $user;

    public function __construct(Article $article, User $user)
    {
        $this->article = $article;
        $this->user = $user;
    }
}
