@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Сравнение пользователей')
@section('description', '')
@section('robots', 'noindex, follow')

@section('content')
    <h1 class="text-center mb-4">Сравнение пользователей</h1>

    <rating-points-compare first="{{ $first->id }}" second="{{ $second->id }}"></rating-points-compare>

    <div class="row mt-4">
        @foreach([$first, $second] as $user)
            <div class="col-6">
                <h2 class="text-center mb-0">{{ $user->name }}</h2>
            </div>
        @endforeach
    </div>

    <div class="row">
        @foreach([$first, $second] as $user)
            <div class="col-6">
                <div class="card mt-3">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="mb-0 font-weight-bold text-primary h2">
                                {{ $user->rating_points()->sum('amount') }}
                            </div>
                            <div class="small text-secondary mb-1">
                                очков за всё время
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="mb-0 font-weight-bold text-secondary h2">
                                {{ $user->articles()->count() }}
                            </div>
                            <div class="small text-secondary mb-1">
                                статей
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="mb-0 font-weight-bold text-secondary h2">
                                {{ $user->events()->count() }}
                            </div>
                            <div class="small text-secondary mb-1">
                                мероприятий, в которые сходил
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="mb-0 font-weight-bold text-secondary h2">
                                {{ $user->events()->travels()->with('travel')->get()->sum(function ($event) {
                                    return $event->pivot->distance_traveled ?? $event->travel->distance;
                                })}}
                            </div>
                            <div class="small text-secondary mb-1">
                                км прошёл в походах
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
