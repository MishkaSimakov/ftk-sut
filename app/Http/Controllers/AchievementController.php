<?php

namespace App\Http\Controllers;

use App\Achievement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use function redirect;
use function view;
use Illuminate\Support\Facades\Auth;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $achievements = Achievement::all();

        return view('achievements.index', compact('achievements'));
    }
}
