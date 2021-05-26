<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\UserPrivateResource;
use App\Models\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $users = UserPrivateResource::collection(
            User::select(['id', 'name', 'register_code', 'email'])->orderBy('name')->get()
        )->toJson();

        return view('admin.index', compact('users'));
    }
}
