<?php

namespace App\Http\Livewire\Articles\Lists;

use App\Models\Article;
use Livewire\Component;

class ArticlesList extends Component
{
    public function getArticles() {
        return Article::paginate(Article::PAGINATION_LIMIT)->load(['author', 'points']);
    }

    public function render()
    {
        return view('livewire.articles.lists.articles-list', [
            'articles' => $this->getArticles()
        ]);
    }
}