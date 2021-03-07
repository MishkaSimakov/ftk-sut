<?php

namespace App\Http\Controllers;


use App\Http\Requests\News\StoreNewsRequest;
use App\Mail\NewsNotification;
use App\Models\News;
use App\Models\User;
use Illuminate\Support\Facades\Mail;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all()->sortByDesc('date');

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

    public function store(StoreNewsRequest $request)
    {
        $news = News::create($request->all());

        if ($request->get('notify_users') == 'on') { // TODO: предусмотреть отсроченную отправку новости (если статья публикуется не сразу)
            Mail::to(User::whereNotNull('email')->select('email')->get())
                ->queue(new NewsNotification($news));
        }

        return redirect()->route('news.index');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->back();
    }
}
