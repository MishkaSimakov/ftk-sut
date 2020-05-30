<?php

namespace App\Http\Controllers\Auth;

use App\Achievements\Events\UserWriteDescription;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUser;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function show(User $user)
    {
        if (!$user->exists) {
            $user = auth()->user();
        }

        return view('user.settings', compact('user'));
    }

    public function update(StoreUser $request)
    {
        Auth::user()->update([
            'phone' => $request->phone,
            'vk_link' => $request->vk_link,
            'email' => $request->email,
            'description' => $request->description,
        ]);

        if ($request->description) {
            UserWriteDescription::dispatch($request->user());
        }

        return redirect()->back();
    }

    public function image(Request $request)
    {
        Storage::delete(auth()->user()->image);

        auth()->user()->update([
            'image' => Arr::first($request->allFiles())->store('user'),
        ]);

        return auth()->user()->imageUrl;
    }
}
