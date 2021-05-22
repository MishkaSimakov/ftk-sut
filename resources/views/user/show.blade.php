@extends('layouts.app', ['includeLivewire' => false])

@section('title', $user->name)

@section('content')
    <h1 class="text-center mb-4">{{ $user->name }}</h1>

    @auth
        @if(auth()->id() !== $user->id)
            <div class="mb-3">
                <a href="{{ route('statistics.compare', $user) }}">Сравнить с собой</a>
            </div>
        @endif
    @endauth

    <rating-points-statistics user="{{ $user->id }}"></rating-points-statistics>

    <div class="text-center my-2">
        <a href="{{ route('statistics.points', $user) }}" class="text-secondary">Подробнее</a>
    </div>

    <articles-statistics user="{{ $user->id }}"></articles-statistics>

    <events-statistics user="{{ $user->id }}"></events-statistics>

    <div>
        <h2 class="h5 mt-5 mb-1">Достижения</h2>

        <div class="card mt-3">
            @if(!$achievements->count())
                <div class="text-center my-3 text-info">
                    Нет достижений
                </div>
            @endif
            <ul class="list-group list-group-flush">
                @foreach($achievements as $achievement)
                    @include('partials.cards.achievement', compact('achievement'))
                @endforeach
            </ul>

            <a class="text-secondary my-2 mx-auto" href="{{ route('achievements.index') }}">
                Список достижений
            </a>
        </div>
    </div>
@endsection
