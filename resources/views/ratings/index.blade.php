@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Рейтинг')
@section('description', 'Возможность сравнить себя с сотнями других учеников по различным параметрам за выбранный промежуток времени.')
@section('robots', 'index, follow')

@section('content')
    <h1 class="text-center mb-4">Рейтинг</h1>

    <ul class="nav nav-pills row text-center">
        <li class="nav-item col-md-4">
            <span class="nav-link active">Очки</span>
        </li>
        <li class="nav-item col-md-4">
            <a class="nav-link" href="{{ route('rating.travels.index') }}">Походы</a>
        </li>
        <li class="nav-item col-md-4" role="presentation" data-toggle="tooltip" title="Этот раздел ещё в разработке">
            <a class="nav-link disabled" id="articles-rating-tab" href="#">Статьи</a>
        </li>
    </ul>

    <div class="mt-3">
        <points-rating></points-rating>
    </div>
@endsection
