@extends('layouts.app')


@section('title', 'Сброс пароля')

@section('content')
    <h1 class="text-center mb-4">Сброс пароля</h1>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-8 col-md-10 col-12">
                @if (session('status'))
                    <div class="alert alert-success mb-3" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('password.email') }}" method="POST">
                            @csrf

                            <div class="form-group">
                                <label for="email">Email</label>
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                                       name="email"
                                       value="{{ old('email') }}" required autofocus autocomplete="email">

                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary mr-2">Прислать ссылку для сброса</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
