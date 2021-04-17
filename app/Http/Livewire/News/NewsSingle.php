<?php

namespace App\Http\Livewire\News;

use Livewire\Component;

class NewsSingle extends Component
{
    public $news;

    public function deleteNews()
    {
        $this->news->delete();
        $this->emit('news.deleted', $this->id);
    }

    public function render()
    {
        return view('livewire.news.news-single');
    }
}
