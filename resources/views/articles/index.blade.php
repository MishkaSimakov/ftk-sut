@extends('layouts.app')


@section('title', 'Статьи')
@section('description', 'Множество увлекательных статей на различные темы от ребят, выпускников и преподавателей ФТК СЮТ. Каждый найдёт здесь что-нибудь интересное для себя.')
@section('robots', 'index, follow, noarchive')

@section('content')
    <h1 class="text-center mb-4">Статьи</h1>

    <articles-search></articles-search>

    <section class="mb-5 mt-4">
        <h2 class="h3 text-left font-weight-bold">Лучшее на ftksut.ru</h2>

        <livewire:articles.lists.best-articles-list/>
    </section>

    <section class="mb-5">
        <div class="row no-gutters">
            <h2 class="h3 text-left font-weight-bold">Популярные категории</h2>
            <a href="{{ route('articles.tags.index') }}" class="text-muted ml-auto my-auto small d-none d-md-block">посмотреть все</a>
        </div>

        <livewire:articles.lists.article-tags-list/>
    </section>

    <section>
        <h2 class="h3 text-left font-weight-bold">Все статьи</h2>

        <livewire:articles.lists.articles-list/>
    </section>
@endsection
