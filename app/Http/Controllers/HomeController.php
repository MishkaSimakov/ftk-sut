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
        $achievements = optional(Auth::user()->student)->achievements;

        return view('home', compact('achievements'));
    }
}
