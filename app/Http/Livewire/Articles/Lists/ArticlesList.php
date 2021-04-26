<?php

namespace App\Http\Livewire\Articles\Lists;

use App\Models\Article;
use Illuminate\Support\Collection;
use Livewire\Component;

class ArticlesList extends Component
{
    public Collection $articles;

    public function loadMore()
    {

    }

    public function getArticlesProperty()
    {
        if (!$this->canLoadArticles) {
            return [];
        }

        return Article::with('author', 'points')->skip($this->skip)->take(Article::PAGINATION_LIMIT)->get();
    }

    public function render()
    {
        return view('livewire.articles.lists.articles-list');
    }
}
