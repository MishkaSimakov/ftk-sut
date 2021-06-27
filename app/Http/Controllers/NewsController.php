<?php

namespace App\Http\Controllers;


use App\Http\Requests\News\StoreNewsRequest;
use App\Http\Resources\News\NewsIndexResource;
use App\Models\News;
use App\Notifications\NewsPublishedNotification;
use Illuminate\Support\Facades\Notification;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(News::class, 'news');
    }

    public function index()
    {
        $news = News::withViewsCount(null, null, true)
            ->latest('date')
            ->paginate(News::PAGINATION_LIMIT);

        foreach ($news as $single) {
            views($single)->record();
        }

        return view('news.index', compact('news'));
    }

    public function edit(News $news)
    {
        return view('news.edit', compact('news'));
    }

    public function update(StoreNewsRequest $request, News $news)
    {
        $news->update($request->validated());

        return redirect()->route('news.index');
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(StoreNewsRequest $request)
    {
        $news = News::make($request->validated());
        $news->date = $request->has('delayed_publication') ? $request->get('date') : now();
        $news->save();

        Notification::route('telegram', config('services.telegram-bot-api.channel_id'))
            ->notify(
                (new NewsPublishedNotification($news))->delay($news->date)
            );

        return redirect()->route('news.index');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->back();
    }
}
