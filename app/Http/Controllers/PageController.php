<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Event;
use App\Models\User;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function welcome()
    {
        $statistics = [
            'users_count' => User::count(),
            'events_count' => Event::count(),
            'articles_count' => Article::checked()->published()->count()
        ];

        return view('welcome', compact('statistics'));
    }
}
