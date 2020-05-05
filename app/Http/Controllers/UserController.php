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
        } else {
            $articles = $user->articles()->where([['is_blank', false], ['is_published', true]])->orderBy('points', 'desc')->paginate(5);

            if ($user->student) {
                $achievements = optional($user->student)->achievements;

                return view('user.show', compact('user', 'achievements', 'articles'));
            } else {
                return view('teacher.show', compact('user', 'articles'));
            }
        }
    }
}
