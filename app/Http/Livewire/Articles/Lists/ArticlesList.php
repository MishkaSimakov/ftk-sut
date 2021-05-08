<?php

namespace App\Http\Livewire\Articles\Lists;

use App\Models\Article;
use Illuminate\Support\Collection;
use Livewire\Component;

class ArticlesList extends Component
{
    public bool $hasMorePages = true;
    public Collection $articles;
    public int $page = 1;

    public function loadMore()
    {
        $articles = $this->getArticles($this->page);

        $this->articles->push(...$articles);

        $this->page++;
    }

    public function mount()
    {
        $this->articles = $this->getArticles(0);
    }

    protected function getArticles(int $page): Collection
    {
        $articles = Article::take(Article::PAGINATION_LIMIT)
            ->skip(Article::PAGINATION_LIMIT * $page)
            ->with(['author', 'points'])
            ->get();

        if ($articles->count() < Article::PAGINATION_LIMIT) {
            $this->hasMorePages = false;
        }

        return $articles;
    }

    public function render()
    {
        return view('livewire.articles.lists.articles-list');
    }
}
