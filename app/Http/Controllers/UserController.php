<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\StoreUserRequest;
use App\Models\User;
use Assada\Achievements\Model\AchievementProgress;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show');
    }

    public function show(User $user)
    {
        $achievements = $user->inProgressAchievements()
            ->concat($user->unlockedAchievements())
            ->sortByDesc(function (AchievementProgress $progress) {
            return $progress->points / $progress->details->points;
        });

        return view('user.show', compact('user', 'achievements'));
    }

    public function home()
    {
        return $this->show(auth()->user());
    }

    public function settings()
    {
        return view('user.settings');
    }


    public function create()
    {
        return view('user.create');
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        return redirect()->route('users.show', $user);
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }
}
