<?php

namespace App\Http\Livewire\News;

use App\Models\News;
use Livewire\Component;

class NewsList extends Component
{
    protected $listeners = [
        'news.deleted' => 'newsDeleted'
    ];

    public function newsDeleted()
    {
        //
    }

    public function render()
    {
        return view('livewire.news.news-list', [
            'news' => News::orderBy('date', 'desc')->paginate(News::PAGINATION_LIMIT)
        ]);
    }
}
