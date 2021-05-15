<?php

namespace App\Http\Controllers;


use App\Events\NewsCreated;
use App\Http\Requests\News\StoreNewsRequest;
use App\Http\Resources\News\NewsIndexResource;
use App\Models\News;

class NewsController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(News::class, 'news');
    }

    public function index()
    {
        $news = News::withViewsCount(null, null, true)
            ->orderBy('date', 'desc')
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
        $news->update($request->all());

        return redirect()->back();
    }

    public function create()
    {
        return view('news.create');
    }

    public function show(News $news)
    {
        return response()->json(
            NewsIndexResource::make($news)
        );
    }

    public function store(StoreNewsRequest $request)
    {
        $news = News::make($request->validated());
        $news->date = $request->get('delayed_publication') === 'on' ? $request->get('date') : now();
        $news->save();

        NewsCreated::dispatch($news, $request->get('notify_users') == 'on');

        return redirect()->route('news.index');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->back();
    }
}
