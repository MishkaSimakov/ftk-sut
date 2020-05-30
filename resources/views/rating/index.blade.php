@extends('layouts.page')

@section('content')

    <h1 class="text-center m-2">Рейтинг</h1>

    @admin
        <h2 class="ml-2"><a href="{{ route('rating.create') }}"><i class="fas fa-plus mr-1"></i>Добавить рейтинг</a></h2>
    @endadmin

    <div class="card">
        @foreach($rating->groupBy('year') as $year)

        @endforeach
    </div>


        <h2 class="ml-2"><a href="{{ $rating->url }}">{{ $rating->name }}</a></h2>
    @endforeach

@endsection
