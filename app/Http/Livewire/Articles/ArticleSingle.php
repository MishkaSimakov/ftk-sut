<?php

namespace App\Http\Livewire\Articles;

use App\Models\Article;
use Livewire\Component;

class ArticleSingle extends Component
{
    public Article $article;

    public function deleteArticle() {
        if (auth()->user()->cannot('delete', $this->article)) {
            abort(403);
        }

        $this->article->delete();
        $this->emit('article.deleted');
    }

    public function render()
    {
        return view('livewire.articles.article-single');
    }
}
