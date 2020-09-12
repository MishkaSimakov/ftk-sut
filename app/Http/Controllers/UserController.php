<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use function compact;

class UserController extends Controller
{
    public function show(User $user) {
        if ($user->id === optional(auth()->user())->id) {
            return redirect(route('home'));
        }

        $achievements = optional($user->student)->achievements;

        return view('user.show', compact('achievements', 'user'));
    }
}
