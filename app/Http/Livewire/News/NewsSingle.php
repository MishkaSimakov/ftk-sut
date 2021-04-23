<?php

namespace App\Http\Livewire\News;

use App\Models\News;
use Livewire\Component;

class NewsSingle extends Component
{
    public News $news;

    public function render()
    {
        return view('livewire.news.news-single');
    }
}
