<?php

namespace App\Http\Livewire\Articles;

use App\Models\Article;
use Livewire\Component;

class ArticleActions extends Component
{
    public Article $article;
    public bool $isLiked = true;

    public function toggleLike()
    {
        if (auth()->user()->cannot('like', $this->article)) {
            abort(403);
        }

        $this->isLiked = $this->article->points()->toggle(auth()->user())['attached'] === [auth()->id()];
    }

    public function render()
    {
//        $this->isLiked = auth()->check() ? $this->article->isLikedBy(auth()->user()) : false;

        return view('livewire.articles.article-actions');
    }
}
