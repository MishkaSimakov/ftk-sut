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
            if (Auth::user()->isTeacher) {
                $achievements = Achievement::where('isTeacher', true)->get();
            } else {
                $achievements = Achievement::whereNull('isTeacher')->get();
            }
        } else {
            $achievements = Achievement::whereNull('isTeacher')->get();
        }

        return view('achievements.index', compact('achievements'));
    }

    public function create()
    {
        return view('achievements.create');
    }

    public function store(Request $request)
    {
        $achievement = Achievement::make();

        $achievement->title = $request->title;
        $achievement->body = $request->body;
        $achievement->image_url = $request->image;

        $achievement->save();

        return redirect(route('achievements.index'));
    }

    public function edit(Achievement $achievement)
    {
        return view('achievements.edit', compact('achievement'));
    }

    public function update(Achievement $achievement, Request $request) {
        $achievement->update(['title' => $request->title]);
        $achievement->update(['body' => $request->body]);
        $achievement->update(['image_url' => $request->image]);

        return redirect(route('achievements.show', $achievement));
    }

    public function destroy(Achievement $achievement)
    {
        $achievement->destroy();

        return redirect('achievements.index');
    }
}
