@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <h1 class="text-center mb-4">{{ $article->title }}</h1>

    <div class="col-xl-9 article-body mx-auto container text-wrap">
        {!! $article->body !!}

        <hr>

        <div class="row no-gutters text-muted align-items-center">
            <ul class="list-inline mr-auto col-9 overflow-hidden">
                @if($article->tags()->count())
                    <li class="list-inline-item">Теги:</li>

                    @foreach($article->tags as $tag)
                        <li class="list-inline-item">
                            <a href="{{ $tag->url }}" title="{{ $tag->name }}">
                                {{ $tag->name }}
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>

            <livewire:articles.article-actions :article="$article"/>
        </div>
    </div>
@endsection
