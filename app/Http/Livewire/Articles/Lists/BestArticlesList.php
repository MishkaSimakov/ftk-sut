<?php

namespace App\Http\Livewire\Articles\Lists;

use App\Models\Article;
use Livewire\Component;

class BestArticlesList extends Component
{
    public function render()
    {
        $sql = '`points_count` * ' . Article::RELEVANCE_COEFFICIENTS['points'] . ' + `views_count` * ' . Article::RELEVANCE_COEFFICIENTS['views'] . ' + datediff(now(), `date`) * ' . Article::RELEVANCE_COEFFICIENTS['days'];
        $articles = Article::with('author', 'points')->withViewsCount()->withCount('points')->orderByRaw($sql . ' desc')->limit(3)->get();

        return view('livewire.articles.lists.best-articles-list', [
            'articles' => $articles
        ]);
    }
}
