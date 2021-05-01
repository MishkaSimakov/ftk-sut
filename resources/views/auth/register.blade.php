@extends('layouts.app', ['includeLivewire' => false])

@section('title', 'Регистрация')

@section('content')
    <h1 class="text-center h1 mb-4">Создайте свой аккаунт</h1>

    <div class="mx-auto col-xl-6 col-md-9">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-group">
                        <div class="row no-gutters">
                            <label for="register_code">Регистрационный код</label>

                            <a class="d-none d-sm-inline text-muted text-decoration-none ml-auto" href="{{ route('password.request') }}">Что
                                это такое?</a>
                            <a class="d-inline d-sm-none text-muted text-decoration-none ml-auto" href="{{ route('password.request') }}">
                                <i class="far fa-question-circle"></i>
                            </a>
                        </div>

                        <input
                            id="register_code" type="text"
                            pattern="[0-9a-zA-Z]{6}" class="form-control @error('register_code') is-invalid @enderror"
                            name="register_code" value="{{ old('register_code') }}"
                            required autofocus
                        >

                        @error('register_code')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="row no-gutters">
                            <label for="email">Email</label>
                        </div>
                        <input
                            id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror"
                            name="email" value="{{ old('email') }}"
                            required autocomplete="email"
                        >

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="row no-gutters">
                            <label for="password">Пароль</label>
                        </div>
                        <input
                            id="password" type="password"
                            class="form-control @error('password') is-invalid @enderror"
                            name="password" required autocomplete="new-password"
                        >

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="row no-gutters">
                            <label for="password-confirm">Подтвердите пароль</label>
                        </div>
                        <input
                            id="password-confirm" type="password" class="form-control" name="password_confirmation"
                            required autocomplete="new-password"
                        >
                    </div>

                    <div class="form-group mb-0">
                        <button class="d-sm-block d-none btn btn-lg btn-primary btn-block" type="submit">Зарегистрироваться</button>
                        <button class="d-sm-none d-block btn btn-primary btn-block" type="submit">Зарегистрироваться</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
