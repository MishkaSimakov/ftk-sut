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
        if (Auth::user()) {
            if (Auth::user()->is_teacher) {
                $achievements = Achievement::where('isTeacher', true)->get();
            } else {
                $achievements = Achievement::whereNull('isTeacher')->get();
            }
        } else {
            $achievements = Achievement::whereNull('isTeacher')->get();
        }

        return view('achievements.index', compact('achievements'));
    }
}
