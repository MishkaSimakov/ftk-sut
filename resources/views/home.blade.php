@extends('layouts.head')

@section('title', 'Личный кабинет')

@section('content')
    @admin
        <div class="alert alert-info" role="alert">
            Вы - администратор. Огромная власть в ваших руках, но вместе с ней и большая ответственность.
        </div>
    @endadmin

    <div class="card">
        <div class="card-header">{{ __('Dashboard') }}</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            {{ __('You are logged in!') }}
        </div>
    </div>
@endsection
