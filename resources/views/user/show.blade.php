@extends('layouts.app', ['includeLivewire' => false])

@section('title', $user->name)

@section('content')
    <h1 class="text-center mb-4">{{ $user->name }}</h1>

    @auth
        @if(auth()->id() !== $user->id)
            <a class="btn btn-primary btn-block">Сравнение</a>
        @endif
    @endauth

    <rating-points-statistics user="{{ $user->id }}"></rating-points-statistics>

    <articles-statistics user="{{ $user->id }}"></articles-statistics>
@endsection
