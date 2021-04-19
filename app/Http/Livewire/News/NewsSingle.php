<?php

namespace App\Http\Livewire\News;

use App\Models\News;
use Livewire\Component;

class NewsSingle extends Component
{
    public News $news;

    public function deleteNews()
    {
        if (auth()->user()->cannot('delete', $this->news)) {
            abort(403);
        }

        $this->news->delete();
        $this->emit('news.deleted');
    }

    public function render()
    {
        return view('livewire.news.news-single');
    }
}
