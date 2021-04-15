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
        return view('news.index');
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
        $news = News::make($request->all());
        $news->date = $request->delayed_publication == 'on' ? $request->get('date') : now();
        $news->save();

        if ($request->get('notify_users') == 'on') { // TODO: предусмотреть отсроченную отправку новости (если статья публикуется не сразу)
            Mail::to(User::whereNotNull('email')->select('email')->get())
                ->later($request->get('date'), new NewsNotification($news));
        }

        return redirect()->route('news.index');
    }

    public function destroy(News $news)
    {
        $news->delete();

        return redirect()->back();
    }
}
