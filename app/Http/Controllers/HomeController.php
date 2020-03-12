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
        if (Auth::user()->student) {
            $user = Auth::user();
            $achievements = $user->student->achievements;

            return view('home.student', compact(['achievements', 'user']));
        } else {
            $user = Auth::user();

            return view('home.teacher', compact('user'));
        }
    }
}
