@extends('layouts.app')

@section('title', 'Статьи')

@section('content')
    <h1 class="text-center mb-4">Статьи</h1>

    <articles-search></articles-search>

    <section class="mb-5 mt-4">
        <h3 class="text-left font-weight-bold">Лучшее на ftk-sut.ru</h3>

{{--        <articles-top-list></articles-top-list>--}}
    </section>

    <section class="mb-5">
        <h3 class="text-left font-weight-bold">Популярные категории</h3>

        <livewire:articles.lists.article-tags-list/>
    </section>

    <section>
        <h3 class="text-left font-weight-bold">Все статьи</h3>

        <livewire:articles.lists.articles-list/>
    </section>
@endsection
