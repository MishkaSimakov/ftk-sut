<?php

namespace App\Http\Livewire\Articles\Lists;

use App\Models\ArticleTag;
use Livewire\Component;

class ArticleTagsList extends Component
{
    public function loadTags()
    {
        return ArticleTag::all()->sortByDesc('articles_count')->take(4);
    }

    public function render()
    {
        $tags = $this->loadTags();

        return view('livewire.articles.lists.article-tags-list', ['tags' => $tags]);
    }
}
