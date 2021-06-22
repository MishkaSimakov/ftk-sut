@extends('layouts.app', ['includeLivewire' => false])


@section('title', 'Рейтинг')
@section('description', 'Возможность сравнить себя с сотнями других учеников по различным параметрам за выбранный промежуток времени.')
@section('robots', 'index, follow')

@section('content')
    <h1 class="text-center mb-4">Рейтинг</h1>

    <ul class="nav nav-pills row text-center" role="tablist">
        <li class="nav-item col-md-4" role="presentation">
            <a class="nav-link active" id="points-rating-tab" data-toggle="tab" href="#points-rating" role="tab"
               aria-selected="false">Очки</a>
        </li>
        <li class="nav-item col-md-4" role="presentation" data-toggle="tooltip" title="Этот раздел ещё в разработке">
            <a class="nav-link disabled" id="travels-rating-tab" data-toggle="tooltip" title="Тест" href="#"
                {{--               data-toggle="tab" href="#travels-rating" role="tab" aria-selected="false"--}}
            >Походы</a>
        </li>
        <li class="nav-item col-md-4" role="presentation" data-toggle="tooltip" title="Этот раздел ещё в разработке">
            <a class="nav-link disabled" id="articles-rating-tab" href="#"
                {{--               data-toggle="tab" href="#articles-rating" role="tab" aria-selected="false"--}}
            >Статьи</a>
        </li>
    </ul>

    <div class="tab-content mt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="points-rating" role="tabpanel" aria-labelledby="points-rating-tab">
            <rating></rating>
        </div>

        <div class="tab-pane fade" id="travels-rating" role="tabpanel" aria-labelledby="travels-rating-tab">
            <!-- Котик для самых любопытных!
                 /\_/\
                ( o.o )
                 > ^ <
            -->
        </div>
        <div class="tab-pane fade" id="articles-rating" role="tabpanel" aria-labelledby="articles-rating-tab">3</div>
    </div>
@endsection
