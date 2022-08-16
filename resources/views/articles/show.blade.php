@extends('layouts.app')


@section('title', $article->title)
@section('description', '')
@section('robots', 'noindex, follow')

@section('content')
    <h1 class="text-center mb-1">{{ $article->title }}</h1>

    <div class="text-center mb-4">
        <span class="text-secondary">
            @if($article->type->isNot(\App\Enums\ArticleType::Checked))
                {{ Str::lower(\App\Enums\ArticleType::getDescription($article->type)) }}
            @endif

            @if($article->type->isNot(\App\Enums\ArticleType::Checked) && $article->isNotPublished)
                    •
            @endif

            @if($article->isNotPublished)
                <span data-toggle="tooltip" title="Статья будет опубликована {{ $article->date->isoFormat('LLL') }}">
                    отложена</span>
            @endif
        </span>
    </div>

    <div class="col-xl-9 article-body mx-auto container text-wrap">
        {!! $article->body !!}

        <hr>

        <div class="row no-gutters text-muted align-items-center">
            <div class="mr-auto col text-nowrap overflow-hidden">
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

        @if($article->type->is(\App\Enums\ArticleType::Checked))
            <livewire:articles.article-comments :article="$article"/>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            $('[data-toggle="tooltip"]').tooltip()

            let img = document.body.getElementsByTagName("img");
            let i = 0;
            while (i < img.length) {
                img[i].setAttribute("data-lity", '');
                i++;
            }
        })
    </script>
@endpush
