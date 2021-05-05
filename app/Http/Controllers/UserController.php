<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\StoreUserRequest;
use App\Models\User;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function show(User $user)
    {
        return view('user.show', compact('user'));
    }

    public function home()
    {
        $achievements = auth()->user()->unlockedAchievements()->sortByDesc('created_at');

        return view('user.home', compact('achievements'));
    }

    public function settings()
    {
        return view('user.settings');
    }


    public function create()
    {
        //
    }

    public function store(StoreUserRequest $request)
    {
        //
    }
}
