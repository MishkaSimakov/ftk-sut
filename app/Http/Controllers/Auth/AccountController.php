<?php

namespace App\Http\Controllers\Auth;

use App\Achievements\Events\UserWriteDescription;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function settings()
    {
        return view('user.settings');
    }

    public function update(Request $request)
    {
        if ($request->password) {
            $validatedData = $request->validate([
                'password' => 'required|string|min:6|confirmed',
            ]);

            Auth::user()->update([
                'password' => Hash::make($validatedData['password'])
            ]);
        } else {
            $validatedData = $request->validate([
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore(Auth::user()->id)
                ],
                'birthday' => 'nullable|date',
                'description' => 'string|max:500',
            ]);

            if (Auth::user()->student) {
                Auth::user()->student->update([
                    'birthday' => Carbon::parse($validatedData['birthday']),
                ]);
            }

            Auth::user()->update([
                'email' => $validatedData['email'],
                'description' => $validatedData['description'],
            ]);

            UserWriteDescription::dispatch($request->user());
        }

        return redirect()->back();
    }
}
