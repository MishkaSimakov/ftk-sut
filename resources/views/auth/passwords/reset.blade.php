@extends('layouts.app')

@section('title', 'Сброс пароля')

@section('content')
    <h1 class="text-center mb-4">Сброс пароля</h1>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-md-10 col-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('password.update') }}" method="POST">
                            @csrf

                            <input type="hidden" name="token" value="{{ $token }}">

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email"
                                       class="form-control @error('email') is-invalid @enderror" name="email"
                                       value="{{ $email ?? old('email') }}" required autofocus autocomplete="email"
                                >

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                         <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password">Пароль</label>
                                <input id="password" type="password"
                                       class="form-control @error('password') is-invalid @enderror" name="password"
                                       required autofocus autocomplete="new-password"
                                >

                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="password-confirm">Подтвердите пароль</label>
                                <input id="password-confirm" type="password"
                                       class="form-control" name="password_confirmation"
                                       required autofocus autocomplete="new-password"
                                >
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">Сохранить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
