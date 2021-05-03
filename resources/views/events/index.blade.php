@extends('layouts.app')

@section('title', 'Расписание')

@section('content')
    <h1 class="text-center mb-4">Расписание</h1>

    @forelse($events as $event)
        <livewire:events.event-single :event="$event" />
    @empty
        Нет мероприятий
    @endforelse
@endsection
