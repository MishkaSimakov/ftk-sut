@extends('layouts.app')

@section('title', 'Статьи')

@section('content')
    <h1 class="text-center mb-4">Статьи</h1>

    <articles-search></articles-search>

    {{-- Best articles --}}
    <section class="mb-5 mt-4">
        <h3 class="text-left font-weight-bold">Статьи</h3>

        @foreach($articles as $article)

        @endforeach
    </section>

    <section class="mb-5">
        <h3 class="text-left font-weight-bold">Теги</h3>

        {{--        <articles-top-tags-list></articles-top-tags-list>--}}
        <livewire:articles.lists.article-tags-list/>
    </section>

    <section>
        <h3 class="text-left font-weight-bold">Авторы</h3>

        {{--        <articles-list></articles-list>--}}
        <livewire:articles.lists.articles-list/>
    </section>
@endsection
