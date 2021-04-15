@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <h1 class="text-center">Настройки аккаунта</h1>

    <div class="card">
        <div class="card-body">
            <form action="{{ route('article.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input id="email" type="email"
                           class="form-control @error('email') is-invalid @enderror" name="email"
                           value="{{ old('email') ?? auth()->user()->email }}"
                    >

                    @error('email')
                    <span class="invalid-feedback" role="alert">
                             <strong>{{ $message }}</strong>
                         </span>
                    @enderror
                </div>
            </form>
        </div>
    </div>
@endsection
