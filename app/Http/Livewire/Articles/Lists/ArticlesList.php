<?php

namespace App\Http\Livewire\Articles\Lists;

use App\Models\Article;
use Livewire\Component;

class ArticlesList extends Component
{
    public function getArticles() {
        $articles = Article::paginate(1)->load(['author', 'points']);

        return $articles;
    }

    public function render()
    {
        return view('livewire.articles.lists.articles-list', [
            'articles' => $this->getArticles()
        ]);
    }
}
