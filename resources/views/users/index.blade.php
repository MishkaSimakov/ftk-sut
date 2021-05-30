@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Пользователи')

@section('content')
    <h1 class="text-center mb-4">Пользователи</h1>

    <ul class="list-unstyled">
        @foreach($users as $user)
            <li>
                <a href="{{ $user->url }}">{{ $user->name }}</a>
            </li>
        @endforeach
    </ul>
@endsection
