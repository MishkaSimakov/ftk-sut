<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\StoreUserRequest;
use App\Http\Requests\Users\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('show', 'index');
    }

    public function index()
    {
        $users = User::orderBy('name')->get();

        return view('users.index', compact('users'));
    }

    public function show(User $user)
    {
        $achievements = $user->achievements()->where('points', '>', 0)->get()->map->details;

        return view('users.show', compact('user', 'achievements'));
    }

    public function home()
    {
        return $this->show(auth()->user());
    }


    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function settings()
    {
        return $this->edit(auth()->user());
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $user->update(
            $request->only('email')
        );

        if ($request->user()->is_admin) {
            $user->update(
                array_merge(
                    $request->only('name', 'type'),
                    [
                        'is_admin' => $request->get('is_admin') === 'on'
                    ]
                )
            );
        }

        return redirect()->back();
    }


    public function create()
    {
        return view('users.create');
    }

    public function store(StoreUserRequest $request)
    {
        $user = User::create($request->validated());

        return redirect()->route('users.show', $user);
    }

    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->back();
    }

    public function articles(User $user)
    {
        $articles = $user->articles()
            ->checked()->published()
            ->withCount('points')->withViewsCount()
            ->latest('date')
            ->get();

        return view('users.articles', compact('articles', 'user'));
    }
}
