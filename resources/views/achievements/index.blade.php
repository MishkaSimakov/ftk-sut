@extends('layouts.app', ['includeLivewire' => false])

@section('title', 'Достижения')

@section('content')
    <h1 class="text-center mb-4">Достижения</h1>

    <ul class="list-group">
        @foreach($achievements as $achievement)
            <li class="list-group-item d-md-flex align-items-center">
                <div class="col-md-6">
                    <div class="text-nowrap">{{ $achievement->name }}</div>
                    <div class="text-muted">{{ $achievement->description }}</div>
                </div>

                @auth
                    <div class="col-md-6 ml-auto mt-2 mt-md-0">
                        <div class="progress">
                            @if($progress = auth()->user()->achievementStatus($achievement->getClass()))
                                <div
                                    class="progress-bar {{ $progress->isUnlocked() ? 'bg-success' : 'bg-secondary' }}"
                                    role="progressbar"
                                    style="width: {{ $progress->points / $achievement->points * 100 }}%;"
                                >
                                    {{ $progress->points }}/{{ $achievement->points }}
                                </div>
                            @endif
                        </div>
                    </div>
                @endauth
            </li>
        @endforeach
    </ul>
@endsection
