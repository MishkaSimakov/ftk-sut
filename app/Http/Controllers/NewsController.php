<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsRequest;
use App\News;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class NewsController extends Controller
{
    public function index()
    {
        $news = News::all()->sortByDesc('created_at');

        $news->each(function ($news) {
            views($news)->cooldown(now()->addHours(1))->record();
        });

        return view('news.index', compact('news'));
    }

    public function create()
    {
        return view('news.create');
    }

    public function store(StoreNewsRequest $request)
    {
        $news = new News;

        $news->title = $request->title;
        $news->body = $request->body;

        $news->save();

        return redirect(route('news.index'));
    }
}
