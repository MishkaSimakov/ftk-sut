@extends('layouts.page', ['title' => $rating->name])

@section('content')
    <h1 class="text-center m-2">{{ $rating->name }}</h1>

    <div class="d-block d-lg-none container">
        <div class="alert alert-success" role="alert">
            <b>Ура!</b> Рейтинг оптимизирован для маленьких экранов!
        </div>
    </div>

    <rating id="{{ $rating->id }}"></rating>
@endsection
