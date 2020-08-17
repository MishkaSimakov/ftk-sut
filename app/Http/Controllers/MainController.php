<?php

namespace App\Http\Controllers;

use App\Article;
use App\Http\Resources\Article\ArticleIndexResource;
use App\News;
use App\Schedule;
use App\Teacher;
use Illuminate\Support\Collection;

class MainController extends Controller
{
    public function index()
    {
//        if (auth()->check()) {
        $news = News::all()->sortByDesc('created_at')->take(3);
        $news->each(function ($news) {
            views($news)->cooldown(now()->addHours(1))->record();
        });

        $articles = ArticleIndexResource::collection(Article::published()->orderByDesc('created_at')->limit(3)->get());

        return view('main.auth', compact('news', 'articles'));
//        }
//
//        $teachers = Teacher::all();
//        $advantages = config('advantages');
//
//        return view('main.guest', compact('teachers', 'advantages'));
    }
}
