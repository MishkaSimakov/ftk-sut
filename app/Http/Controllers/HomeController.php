<?php

namespace App\Http\Controllers;

use App\Achievements\Articles\LikeSelfArticle;
use App\Achievements\Articles\Set10Likes;
use App\Achievements\Articles\SetFirstLike;
use App\Achievements\Articles\Write10Articles;
use App\Achievements\Travels\GoTo10Travels;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $achievements = auth()->user()->unlockedAchievements()->sortByDesc('created_at');

        return view('user.home', compact('achievements'));
    }

    public function settings()
    {
        return view('user.settings');
    }
}
