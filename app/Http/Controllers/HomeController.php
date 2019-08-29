<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\UserAchievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $achievements = Achievement::all()->filter(function ($achievement) {
            if (UserAchievement::where([['achievement_id', $achievement->id], ['user_id', Auth::user()->id]])->exists()) {
                return UserAchievement::where([['achievement_id', $achievement->id], ['user_id', Auth::user()->id]])->first()->completed;
            }

            return false;
        });

        return view('home', compact('achievements'));
    }
}
