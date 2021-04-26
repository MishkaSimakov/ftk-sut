<?php

namespace App\Http\Livewire\Articles\Lists;

use App\Models\Article;
use Livewire\Component;

class BestArticlesList extends Component
{
    public function render()
    {
        $articles = Article::all()->sortByDesc('relevance')->take(3)->values(); // TODO: переписать это на SQL

        return view('livewire.articles.lists.best-articles-list', [
            'articles' => $articles
        ]);
    }
}
