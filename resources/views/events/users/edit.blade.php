@extends('layouts.app')

@section('title', 'Мероприятия')

@section('content')
    <h1 class="text-center mb-4">{{ $event->name }}</h1>

    <div class="card">
        <div class="card-body">
            <livewire:events.change-users-list-form :event="$event"/>
        </div>
    </div>
@endsection
