@extends('layouts.app')


@section('title', 'Статьи')
@section('description', '')
@section('robots', 'noindex, follow')

@section('content')

    <h1 class="h1 text-center mb-4 d-none d-md-block">{{ $query }}</h1>
    <h1 class="text-center mb-4 d-block d-md-none">Результаты поиска</h1>

    <articles-search></articles-search>

    @if($articles->count())
        <div class="mt-3">
            @foreach($articles as $article)
                <livewire:articles.article-single :article="$article" :key="$article->id"/>
            @endforeach
        </div>
    @else
        <div class="my-3 text-center h6 text-info">
            Нет статей по данному запросу
        </div>
    @endif
@endsection
