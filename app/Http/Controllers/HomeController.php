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
        $user = Auth::user();
        $articles = $user->articles()->where([['is_blank', false], ['is_published', true]])->orderBy('points', 'desc')->paginate(5);

        if (Auth::user()->student) {
            $achievements = $user->student->achievements;

            return view('home.student', compact(['achievements', 'user', 'articles']));
        } else {
            return view('home.teacher', compact('user', 'articles'));
        }
    }
}
