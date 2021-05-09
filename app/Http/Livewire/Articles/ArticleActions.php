<?php

namespace App\Http\Livewire\Articles;

use App\Models\Article;
use Livewire\Component;

class ArticleActions extends Component
{
    public Article $article;
    public string $unique;

    public function toggleLike()
    {
        if (auth()->user()->cannot('like', $this->article)) {
            abort(403);
        }

        $this->article->toggleLikeBy(auth()->user());
        $this->article->refresh();
    }

    public function mount()
    {
        $this->unique = uniqid();
    }

    public function render()
    {
        return view('livewire.articles.article-actions');
    }
}
