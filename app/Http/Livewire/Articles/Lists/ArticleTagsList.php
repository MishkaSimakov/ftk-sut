<?php

namespace App\Http\Livewire\Articles\Lists;

use App\Models\ArticleTag;
use Livewire\Component;

class ArticleTagsList extends Component
{
    public function loadTags()
    {
        return ArticleTag::whereHas('articles', function ($query) {
            $query->checked()->published();
        })->withCount(['articles' => function ($query) {
            $query->checked()->published();
        }])->orderByDesc('articles_count')->take(4)->get();
    }

    public function render()
    {
        $tags = $this->loadTags();

        return view('livewire.articles.lists.article-tags-list', ['tags' => $tags]);
    }
}
