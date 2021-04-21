<?php

namespace App\Http\Livewire\Articles;

use App\Models\Article;
use Livewire\Component;

class ArticleActions extends Component
{
    public Article $article;

    public function toggleLike()
    {
        if (auth()->user()->cannot('like', $this->article)) {
            abort(403);
        }

        $this->article->points()->toggle(auth()->user());
    }

    public function render()
    {
        return view('livewire.articles.article-actions');
    }
}
