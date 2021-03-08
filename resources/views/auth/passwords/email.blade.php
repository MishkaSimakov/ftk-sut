@extends('layouts.app')

@section('content')
    <h1 class="text-center h1 mb-4">Восстановление пароля</h1>

    <div class="mx-auto" style="max-width: 350px;">
        @if (session('status'))
            <div class="alert alert-success mb-2" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <form method="POST" action="{{ route('password.email') }}">
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

                    <div class="form-group mb-0">
                        <button class="btn btn-lg btn-primary btn-block" type="submit">
                            Прислать ссылку для восстановления
                        </button>
                    </div>
                </form>
            </div>
        </div>
@endsection
