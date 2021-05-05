@extends('layouts.app')

@section('title', 'Расписание')

@section('content')
    <h1 class="text-center mb-4">Расписание</h1>

    @forelse($events as $event)
        <livewire:events.event-single :event="$event" :key="$event->id"/>
    @empty
        <div class="my-3 text-center h6 text-info">
            <span>Нет мероприятий</span>
        </div>
    @endforelse
@endsection
