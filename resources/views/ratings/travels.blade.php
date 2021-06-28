@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Рейтинг')
@section('description', 'Возможность сравнить себя с сотнями других учеников по различным параметрам за выбранный промежуток времени.')
@section('robots', 'index, follow')

@section('content')
    <h1 class="text-center mb-4">Рейтинг</h1>

    <ul class="nav nav-pills row text-center">
        <li class="nav-item col-md-4">
            <a class="nav-link" href="{{ route('rating.index') }}">Очки</a>
        </li>
        <li class="nav-item col-md-4">
            <a class="nav-link active">Походы</a>
        </li>
        <li class="nav-item col-md-4">
            <a class="nav-link" href="{{ route('ratings.articles.index') }}">Статьи</a>
        </li>
    </ul>

    <div class="mt-3">
        <travels-rating></travels-rating>
    </div>
@endsection
