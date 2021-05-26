<?php

namespace App\Http\Livewire\Articles\Lists;

use App\Models\Article;
use Livewire\Component;

class BestArticlesList extends Component
{
    public function render()
    {
        $articles = Article::checked()->published()
            ->with(['author', 'points'])->withCount('points')->withViewsCount()
            ->orderByRelevance()->limit(3)
            ->get();

        return view('livewire.articles.lists.best-articles-list', [
            'articles' => $articles
        ]);
    }
}
