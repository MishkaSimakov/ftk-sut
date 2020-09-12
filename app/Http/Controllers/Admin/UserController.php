<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UserController extends Controller
{
    public function create()
    {
        return view('admin.user.create');
    }

    public function store(Request $request)
    {
        User::make([
            'name' => $request->surname . ' ' . $request->name,
            'is_admin' => $request->is_admin === 'on',
            'register_code' => Str::random(6),
        ])->save();

        return redirect(route('admin.index'));
    }
}
