@extends('layouts.app', ['includeLivewire' => false])

@section('title', 'Личный кабинет')

@section('content')
    <h1 class="text-center mb-4">{{ auth()->user()->name }}</h1>

    <rating-points-statistics user="{{ auth()->id() }}"></rating-points-statistics>

    <articles-statistics user="{{ auth()->id() }}"></articles-statistics>

    <event-statistics user="{{ auth()->id() }}"></event-statistics>
@endsection
