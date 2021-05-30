@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Статьи пользователя')

@section('content')
    <h1 class="text-center mb-4">{{ $user->name }}</h1>

    <h2 class="h5 mb-1">Статьи</h2>

    <div class="card">
        @if(!$articles->count())
            <div class="text-center my-3 text-info">
                Нет статей
            </div>
        @else
            <ul class="list-group list-group-flush">
                @foreach($articles as $article)
                    <li class="list-group-item d-flex">
                        <a href="{{ $article->url }}" class="text-nowrap text-truncate col-9">{{ $article->title }}</a>

                        <div class="ml-auto text-muted row align-items-center flex-nowrap">
                            <div class="mr-2 mr-md-3 article-like-button" style="cursor: default !important;">
                                <i class="far fa-heart"></i>
                                <span> {{ $article->points_count }}</span>
                            </div>

                            <span class="mr-2 d-none d-md-inline article-views"><i class="far fa-eye"></i> {{ $article->views_count }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection
