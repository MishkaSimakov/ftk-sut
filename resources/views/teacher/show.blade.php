@extends('layouts.page')

@section('content')

<h1 class="text-center m-2">{{ $user->name }}</h1>

@if ($achievements->count())
    <div>
        <div class="text-center">
            <h2>Достижения</h2>

            @foreach($achievements as $achievement)
                <div class="card m-3 d-inline-block" style="width: 18rem">
                    <img class="card-img-top" src="{{ $achievement->icon }}" alt="Изображение от достижения">

                    <div class="card-body">
                        <h5 class="card-title">{{ $achievement->name }}</h5>
                        <p class="card-text">{{ $achievement->description }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif

@endsection
