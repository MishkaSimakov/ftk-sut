<?php

namespace App\Http\Livewire\News;

use App\Models\News;
use Livewire\Component;

class NewsList extends Component
{
    public function render()
    {
        $news = News::withViewsCount(null, null, true)->orderBy('date', 'desc')->paginate(News::PAGINATION_LIMIT);
        foreach ($news as $single) {
            views($single)->record();
        }

        return view('livewire.news.news-list', [
            'news' => $news
        ]);
    }
}
