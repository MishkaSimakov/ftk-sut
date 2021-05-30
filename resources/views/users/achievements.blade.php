@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Достижения')

@section('content')
    <h1 class="text-center mb-4">{{ $user->name }}</h1>

{{--    TODO: добавить глобальную статистику достижений --}}

    <h2 class="h5 mb-1">Достижения</h2>

    <div class="card">
        @if(!$achievements->count())
            <div class="text-center my-3 text-info">
                Нет достижений
            </div>
        @else
            <ul class="list-group list-group-flush">
                @foreach($achievements as $achievement)
                    @include('partials.cards.achievement', compact('achievement'))
                @endforeach
            </ul>
        @endif
    </div>
@endsection
