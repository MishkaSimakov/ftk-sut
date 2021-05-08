@extends('layouts.app')

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
                    <a class="list-group-item list-group-item-action" href="{{ route('article.create') }}">
                        Написать статью
                    </a>
                @endcan

                @can('create', \App\Models\Event::class)
                    <a class="list-group-item list-group-item-action" href="{{ route('events.create') }}">
                        Создать мероприятие
                    </a>
                @endcan
                @admin
                <a class="list-group-item list-group-item-action" href="{{ route('rating.create') }}">
                    Загрузить рейтинг
                </a>
                @endadmin

                <a class="list-group-item list-group-item-action" href="{{ route('users.create') }}">
                    Добавить пользователя
                </a>
            </div>
        </div>
    </section>

    <section class="mb-5">
        <h2 class="h3 text-left font-weight-bold">Управление пользователями</h2>

        <admin-users-datatable users="{{ $users }}"></admin-users-datatable>
    </section>

    <section class="mb-5">
        <h2 class="h3 text-left font-weight-bold">Управление достижениями</h2>

        <div class="card">
            <div class="list-group-flush">
                @foreach(\Assada\Achievements\Achievement::all() as $achievement)
                    <div class="list-group-item">
                        {{ $achievement->name }} <span class="text-muted">({{ $achievement->description }})</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endsection
