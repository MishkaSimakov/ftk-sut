@extends('layouts.app', ['includeLivewire' => false])


@section('title', $user->name)
@section('description', '')
@section('robots', 'noindex, follow')

@section('content')
    <h1 class="text-center mb-4">{{ $user->name }}</h1>

    @auth
        @if(auth()->id() !== $user->id)
            @if($user->showPointsStatistics())
                <div class="mb-3">
                    <a href="{{ route('statistics.compare', $user) }}">Сравнить с собой</a>
                </div>
            @endif
        @else
            @if($event = $user->events()->whereBetween('date_start', [now(), now()->addDay()])->first())
                <div class="alert alert-info" role="alert">
                    {{ Str::ucfirst($event->date_start->diffForHumans()) }} {{ $event->name }}. Не проспите!
                </div>
            @endif
        @endif
    @endauth

    @if($user->showPointsStatistics())
        <rating-points-statistics user="{{ $user->id }}"></rating-points-statistics>
    @endif

    <articles-statistics user="{{ $user->id }}"></articles-statistics>

    <events-statistics user="{{ $user->id }}"></events-statistics>

    <div>
        <h2 class="h5 mt-5 mb-1">Достижения</h2>

        <div class="card mt-3">
            @if(!$achievements->count())
                <div class="text-center py-3 text-info border-bottom">
                    Нет достижений
                </div>
            @else
                <ul class="list-group list-group-flush">
                    @foreach($achievements as $achievement)
                        @include('partials.cards.achievement', compact('achievement'))
                    @endforeach
                </ul>
            @endif

            <a class="text-secondary my-2 mx-auto" href="{{ route('users.achievements', $user) }}">
                Все достижения
            </a>
        </div>
    </div>
@endsection
