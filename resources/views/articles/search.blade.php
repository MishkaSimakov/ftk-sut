@extends('layouts.app')

@section('title', 'Статьи')

@section('content')
    <h1 class="h1 text-center mb-4 d-none d-md-block">Результаты по запросу "{{ $query }}"</h1>
    <h1 class="text-center mb-4 d-block d-md-none">Результаты поиска</h1>

    <articles-search query="{{ $query }}"></articles-search>

    @if($articles->count())
        <section class="mb-5 mt-4">
            <h3 class="text-left font-weight-bold">Статьи</h3>

            @foreach($articles as $article)
                <livewire:articles.article-single :article="$article" :key="$article->id"/>
            @endforeach
        </section>
    @endif

    @if($tags->count())
        <section class="mb-5">
            <h3 class="text-left font-weight-bold">Теги</h3>

            @foreach($tags as $tag)
                {{ $tag->name }}
            @endforeach
        </section>
    @endif

    @if($users->count())
        <section>
            <h3 class="text-left font-weight-bold">Авторы</h3>

            @foreach($users as $user)
                {{ $user->name }}
            @endforeach
        </section>
    @endif
@endsection
