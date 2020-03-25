<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use function compact;

class UserController extends Controller
{
    public function show(User $user) {
        if ($user->student) {
            $achievements = optional($user->student)->achievements;

            return view('user.show', compact('user', 'achievements'));
        } else {
            return view('teacher.show', compact('user'));
        }
    }
}
