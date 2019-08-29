<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Achievement;
use App\UserAchievement;
use function compact;

class UserController extends Controller
{
    public function index() {
    	$users = User::all();

    	return view('user.index', compact('users'));
    }

    public function show(User $user) {
        $GLOBALS['user'] = $user;

    	$achievements = Achievement::all()->filter(function ($achievement) {
    		global $user;

    		if (UserAchievement::where([['achievement_id', $achievement->id], ['user_id', $user->id]])->exists()) {
                return UserAchievement::where([['achievement_id', $achievement->id], ['user_id', $user->id]])->first()->completed;
            }

            return false;
    	});

    	return view('user.show', compact('user', 'achievements'));
    }
}
