@extends('layouts.page')

@section('content')

    <div class="container">
        <div class="card shadow mt-2">
            <div class="card-header">Восстановление пароля</div>

            <div class="card-body">
                <form method="POST" action="{{ route('password.reset') }}">
                    @csrf

                    <div class="form-group row">
                        <label for="email" class="col-sm-4 col-form-label text-md-right">Email</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required autofocus>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('email') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="register_code" class="col-sm-4 col-form-label text-md-right">Регистрационный код</label>

                        <div class="col-md-6">
                            <input id="register_code" type="text" class="form-control{{ $errors->has('register_code') ? ' is-invalid' : '' }}" name="register_code" value="{{ old('register_code') }}" required autofocus>

                            @if ($errors->has('register_code'))
                                <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('register_code') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-8 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Восстановить
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
