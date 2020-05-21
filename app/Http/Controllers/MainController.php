<?php

namespace App\Http\Controllers;

use App\Article;
use App\News;
use App\Teacher;
use Illuminate\Support\Collection;

class MainController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        $advantages = config('advantages');

        $news = News::all()->sortBy('created_at')->sortByDesc('created_at')->take(3);
        $news->each(function ($news) {
            views($news)->cooldown(now()->addHours(1))->record();
        });

        return view('main', compact('teachers', 'advantages', 'news'));

//        $articles = Article::all();
//
//        $tape =
    }
}
