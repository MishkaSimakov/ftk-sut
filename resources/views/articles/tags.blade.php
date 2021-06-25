@extends('layouts.app')


@section('title', 'Категории статей')
@section('description', '')
@section('robots', 'noindex, follow')

@section('content')
    <h1 class="text-center mb-4">Категории</h1>

    <ul class="list-group col-md-8 mx-auto">
        @foreach($tags as $tag)
        <li class="list-group-item d-flex justify-content-between align-items-center">
            <a href="{{ $tag->url }}">{{ $tag->name }}</a>
            <span class="badge badge-secondary badge-pill" title="Количество статей в данной категории">{{ $tag->articles_count }}</span>
        </li>
        @endforeach

    </ul>
@endsection
