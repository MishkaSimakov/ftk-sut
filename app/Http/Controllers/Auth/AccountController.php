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
    public function show()
    {
        return view('auth.settings');
    }

    public function save(Request $request)
    {
        $validatedData = $request->validate([
            'email' => [
                'required',
                'email',
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
           'email' => $validatedData['email'],
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
