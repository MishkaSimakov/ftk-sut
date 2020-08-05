<?php

namespace App\Http\Controllers;

use App\Achievement;
use App\UserAchievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $achievements = optional($user->student)->achievements;
        $articles = $user->articles()->paginate(5);

        return view('user.home', compact('achievements', 'user', 'articles'));
    }
}
