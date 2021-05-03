@extends('layouts.app')

@section('title', $article->title)

@section('content')
    <h1 class="text-center mb-4">{{ $article->title }}</h1>

    <div class="col-xl-9 article-body mx-auto container text-wrap">
        {!! $article->body !!}

        <hr>

        <div class="row no-gutters text-muted align-items-center">
            <div class="mr-auto col-9 overflow-hidden">
                <a href="{{ $article->author->url }}">{{ $article->author->name }}</a>
            </div>

            <livewire:articles.article-actions :article="$article"/>
        </div>

        @if($article->tags->count())
            <ul class="list-inline mt-2 text-muted">
                <li class="list-inline-item">Теги:</li>

                @foreach($article->tags as $tag)
                    <li class="list-inline-item">
                        <a href="{{ $tag->url }}" title="{{ $tag->name }}">
                            {{ $tag->name }}
                        </a>
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function (event) {
            let img = document.body.getElementsByTagName("img");
            let i = 0;
            while (i < img.length) {
                img[i].setAttribute("data-lity", '');
                i++;
            }
        })
    </script>
@endpush
