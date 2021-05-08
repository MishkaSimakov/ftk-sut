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
                    <li class="list-group-item d-md-flex align-items-center">
                        <div class="col-md-6">
                            <div class="text-nowrap">{{ $achievement->name }}</div>
                            <div class="text-muted">({{ $achievement->description }})</div>
                        </div>

                        <div class="col-md-6 ml-auto mt-2 mt-md-0">
                            <div class="progress">
                                <div
                                    class="progress-bar {{ $achievement->isUnlocked() ? 'bg-success' : 'bg-secondary' }}" role="progressbar"
                                    style="width: {{ $achievement->points / $achievement->details->points * 100 }}%;"
                                >
                                    {{ $achievement->points }}/{{ $achievement->details->points }}
                                </div>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>

            <a class="text-secondary my-2 mx-auto" href="{{ route('achievements.index') }}">
                Список достижений
            </a>
        </div>
    </div>
@endsection
