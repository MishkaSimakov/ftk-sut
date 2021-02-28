<?php

namespace App\Http\Controllers;


use App\Http\Resources\News\NewsIndexResource;
use App\Models\News;

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
}
