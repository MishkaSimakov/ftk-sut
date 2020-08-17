<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{
    public function index()
    {
        return view('auth.password.reset');
    }

    public function reset(Request $request)
    {
        $validatedData = $request->validate(
            [
                'email' => 'required|email|exists:users,email',
                'register_code' => 'required|string',
            ],
            [
                'email.required' => 'Это обязательное поле!',
                'email.email' => 'Здесь должен быть email!',
                'email.exists' => 'Нет пользователя с таким email!',

                'register_code.required' => 'Это обязательное поле!',
                'register_code.string' => 'Здесь должен быть регистрационный код!',
            ]
        );

        $user = User::where([
            ['email', $validatedData['email']],
            ['register_code', $validatedData['register_code']]
        ])->first();

        if ($user) {
            Auth::login($user, false);

            return redirect(route('password.change'));
        }

        return redirect()->back()
            ->withErrors([
                'register_code' => 'Вы указали неверный регистрационный код!'
            ])
            ->withInput();
    }

    public function change()
    {
        $user = Auth::user();

        return view('auth.password.change', compact('user'));
    }

    public function update(Request $request)
    {
        $validatedData = $request->validate([
            'password' => 'required|string|min:6|confirmed',
        ], [
            'password.required' => 'Это обязательное поле!',
            'password.string' => 'Здесь должна быть строка!',
            'password.min' => 'Минимальная длина пароля - 6 символов!',
            'password.confirmed' => 'Поля "Пароль" и "Повторите пароль" должны совпадать!'
        ]);

        Auth::user()->update([
            'password' => Hash::make($validatedData['password'])
        ]);

        return redirect(route('home'));
    }
}
