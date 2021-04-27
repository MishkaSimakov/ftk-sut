<?php

namespace App\Http\Livewire\Articles\Lists;

use App\Models\Article;
use Illuminate\Support\Collection;
use Livewire\Component;

class ArticlesList extends Component
{
    public Collection $articles;
    public int $skip = 0;

    public function loadMore()
    {
        $this->articles = $this->articles->concat(
            Article::with('author', 'points')->withViewsCount()->skip($this->skip)->take(Article::PAGINATION_LIMIT)->get()
        );

        $this->skip += Article::PAGINATION_LIMIT;
    }

    public function mount()
    {
        $this->articles = collect();
    }

    public function render()
    {
        return view('livewire.articles.lists.articles-list');
    }
}
