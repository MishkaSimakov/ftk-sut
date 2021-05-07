@extends('layouts.app', ['includeLivewire' => false])

@section('title', $user->name)

@section('content')
    <h1 class="text-center mb-4">{{ $user->name }}</h1>

    @auth
        @if(auth()->id() !== $user->id)
            <a class="btn btn-primary btn-block mb-3">Сравнить</a>
        @endif
    @endauth

    <rating-points-statistics user="{{ $user->id }}"></rating-points-statistics>

    <articles-statistics user="{{ $user->id }}"></articles-statistics>
@endsection
