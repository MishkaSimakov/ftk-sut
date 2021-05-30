@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Достижения')

@section('content')
    <h1 class="text-center mb-4">Достижения</h1>

{{--    TODO: добавить глобальную статистику достижений --}}

    <ul class="list-group">
        @foreach($achievements as $achievement)
            @include('partials.cards.achievement', compact('achievement'))
        @endforeach
    </ul>
@endsection
