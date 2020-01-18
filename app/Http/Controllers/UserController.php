<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use function compact;

class UserController extends Controller
{
    public function show(User $user) {
        $achievements = optional($user->student)->achievements;
        $articles = $user->articles()->orderBy('points', 'desc')->get();

    	return view('user.show', compact('user', 'achievements', 'articles'));
    }
}
