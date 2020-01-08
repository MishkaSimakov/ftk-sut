<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AccountController extends Controller
{
    public function showSettingsForm()
    {
        return view('auth.settings');
    }

    public function saveSettings(Request $request)
    {
        $validatedData = $request->validate([
            'login' => [
                'required',
                'string',
                'min: 5',
                'max:255',
                Rule::unique('users')->ignore(Auth::user()->id)
            ],
            'birthday' => 'date'
        ]);

        if (Auth::user()->student) {
            Auth::user()->student->update([
                'birthday' => Carbon::parse($validatedData['birthday']),
            ]);
        }

        Auth::user()->update([
           'login' => $validatedData['login'],
        ]);

        return redirect()->back();
    }

    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ]);

        Auth::user()->update([
            'password' => Hash::make($validatedData['password'])
        ]);

        return redirect()->back();
    }
}
