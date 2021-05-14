@extends('layouts.app')

@section('title', 'Статьи')

@section('content')
    <h1 class="text-center mb-4">Статьи</h1>

    <articles-search></articles-search>

    <section class="mb-5 mt-4">
        <h2 class="h3 text-left font-weight-bold">Лучшее на ftk-sut.ru</h2>

        <livewire:articles.lists.best-articles-list/>
    </section>

    <section class="mb-5">
        <h2 class="h3 text-left font-weight-bold">Популярные категории</h2>

        <livewire:articles.lists.article-tags-list/>
    </section>

    <section>
        <h2 class="h3 text-left font-weight-bold">Все статьи</h2>

        <livewire:articles.lists.articles-list/>
    </section>
@endsection
