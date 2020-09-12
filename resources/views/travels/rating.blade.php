@extends('layouts.page')

@section('content')

    <h1 class="text-center m-2">Походный рейтинг за {{ $year }} гг.</h1>

    <rating type="travel" url="{{ route('api.travels.rating.show', compact('year')) }}"></rating>

@endsection
