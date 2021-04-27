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
        $news = News::withViewsCount()->orderBy('date', 'desc')->paginate(News::PAGINATION_LIMIT);
        $news->each(function ($news) {
            views($news)->cooldown(now()->addYear())->record();
        });

        return view('livewire.news.news-list', [
            'news' => $news
        ]);
    }
}
