<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Achievement;
use App\UserAchievement;
use Illuminate\Support\Facades\Auth;
use function compact;

class UserController extends Controller
{
    public function index() {
    	$users = User::all();

    	return view('user.index', compact('users'));
    }

    public function show(User $user) {
        $achievements = $user->achievements;

    	return view('user.show', compact('user', 'achievements'));
    }
}
