<?php

namespace App\Http\Livewire\Articles\Lists;

use App\Models\Article;
use Livewire\Component;

class ArticlesList extends Component
{
    public int $perPage = Article::PAGINATION_LIMIT;
    public bool $hasMorePages;

    public function loadMore()
    {
        $this->perPage += Article::PAGINATION_LIMIT;
    }

    public function render()
    {
        $articles = Article::paginate($this->perPage);
        $this->hasMorePages = $articles->hasMorePages();

        return view('livewire.articles.lists.articles-list', [
            'articles' => $articles
        ]);
    }
}
