@extends('layouts.app', ['includeLivewire' => false])

@section('title', 'Вход в аккаунт')

@section('content')
    <h1 class="text-center mb-4">Войти</h1>

    <div class="mx-auto" style="max-width: 350px;">
        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email"
                               value="{{ old('email') }}" required autocomplete="email" autofocus>

                        @error('email')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="row no-gutters">
                            <label for="password">Пароль</label>
                            <a class="text-muted text-decoration-none ml-auto" href="{{ route('password.request') }}">Забыли
                                пароль?</a>
                        </div>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="current-password" autofocus>

                        @error('password')
                        <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                        @enderror
                    </div>

                    <div class="form-group row no-gutters">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember"
                                   id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                Запомнить меня
                            </label>
                        </div>
                    </div>

                    <div class="form-group mb-0">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">Войти</button>
                    </div>
                </form>
            </div>
        </div>

        <div class="card mt-2">
            <div class="card-body text-center">
                Впервые здесь? <a href="{{ route('register') }}">Создайте аккаунт</a>.
            </div>
        </div>
    </div>
@endsection
