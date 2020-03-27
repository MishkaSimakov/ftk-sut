<?php

namespace App\Http\Controllers;

use App\News;
use App\Teacher;

class MainController extends Controller
{
    public function index()
    {
        $teachers = Teacher::all();
        $advantages = config('advantages');
        $news = News::all()->sortBy('created_at')->take(3)->sortByDesc('created_at');

        return view('main', compact('teachers', 'advantages', 'news'));
    }
}
