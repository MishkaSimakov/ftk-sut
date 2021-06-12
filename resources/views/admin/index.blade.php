@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Панель администратора')

@section('content')
    <h1 class="text-center mb-4">Панель администратора</h1>

    <section class="mb-5">
        <h2 class="h3 text-left font-weight-bold">Основные действия</h2>

        <div class="card">
            <div class="list-group-flush">
                @can('create', \App\Models\News::class)
                    <a class="list-group-item list-group-item-action" href="{{ route('news.create') }}">
                        Написать новость
                    </a>
                @endcan

                @can('create', \App\Models\Article::class)
                    <a class="list-group-item list-group-item-action" href="{{ route('articles.create') }}">
                        Написать статью
                    </a>
                @endcan

                @can('create', \App\Models\Event::class)
                    <a class="list-group-item list-group-item-action" href="{{ route('events.create') }}">
                        Создать мероприятие
                    </a>
                @endcan

                <a class="list-group-item list-group-item-action" href="{{ route('rating.create') }}">
                    Загрузить рейтинг
                </a>

                <a class="list-group-item list-group-item-action" href="{{ route('users.create') }}">
                    Добавить пользователя
                </a>

                <a class="list-group-item list-group-item-action" href="{{ route('reviews.index') }}">
                    Посмотреть отзывы
                </a>
            </div>
        </div>
    </section>

    <section class="mb-5">
        <h2 class="h3 text-left font-weight-bold">Управление пользователями</h2>

        <admin-users-datatable users="{{ $users }}"></admin-users-datatable>
    </section>

    {{--    TODO: добавить управление достижениями. --}}
@endsection
