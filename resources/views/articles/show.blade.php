@extends('layouts.app')

@section('title', 'Статьи')

@section('content')
    <h1 class="text-center mb-4">{{ $article->title }}</h1>

    <div class="col-xl-9 article-body mx-auto container">
        {!! $article->body !!}

        <hr>

        <ul class="list-inline">
            <li class="list-inline-item">Теги:</li>
            <li class="list-inline-item">Робототехника</li>
            <li class="list-inline-item">Электроника</li>
            <li class="list-inline-item">Тест</li>
        </ul>
    </div>
@endsection
