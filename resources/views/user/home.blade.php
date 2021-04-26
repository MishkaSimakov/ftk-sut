@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('content')
    <h1 class="text-center">{{ auth()->user()->name }}</h1>

    <h2>
        Достижения
    </h2>

    <div class="row">
        @foreach($achievements as $achievement)
            <div class="col-md-3 mt-2">
                <div class="card h-100">
                    <div class="card-body d-flex flex-column">
                        <div>{{ $achievement->name }}</div>
                        <div class="text-muted">{{ $achievement->description }}</div>

                        <div class="progress mt-auto">
                            <div class="progress-bar bg-success"
                                 role="progressbar"
                                 style="width: 100%"
                                 aria-valuenow="100"
                                 aria-valuemin="0"
                                 aria-valuemax="100"
                            ></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
