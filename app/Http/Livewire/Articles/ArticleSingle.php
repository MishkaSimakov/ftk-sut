<?php

namespace App\Http\Livewire\Articles;

use App\Models\Article;
use Livewire\Component;

class ArticleSingle extends Component
{
    public Article $article;

    public function render()
    {
        return view('livewire.articles.article-single');
    }
}
