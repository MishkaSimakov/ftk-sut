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
     */
    public function index()
    {
        $achievements = Auth::user()->achievements;

        return view('home', compact('achievements'));
    }
}
