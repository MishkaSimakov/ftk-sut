@extends('layouts.page', ['title' => $rating->name])

@section('content')
    <h1 class="text-center m-2">{{ $rating->name }}</h1>

    <rating type="points" url="{{ route('api.rating.show', compact('rating')) }}"></rating>
@endsection
