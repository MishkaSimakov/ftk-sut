<?php

namespace App\Http\Controllers;

use App\Article;
use App\News;
use App\Schedule;
use App\Teacher;
use Illuminate\Support\Collection;

class MainController extends Controller
{
    public function index()
    {
//        $teachers = Teacher::all();
//        $advantages = config('advantages');

        $news = News::all()->sortByDesc('created_at')->take(3);
        $news->each(function ($news) {
            views($news)->cooldown(now()->addHours(1))->record();
        });

        $articles = Article::published()->orderBy('created_at')->limit(3)->get();

        return view('main', compact('news', 'articles'));
    }
}
