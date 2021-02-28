@extends('layouts.app')


@section('title', 'Рейтинг')

@section('content')
    <h1 class="text-center">Рейтинг ФТК</h1>

    <ul class="nav nav-pills row text-center">
        <li class="nav-item col-md-4" role="presentation">
            <a class="nav-link active" id="points-rating-tab" data-toggle="tab" href="#points-rating" role="tab"
               aria-controls="profile" aria-selected="false">Очки</a>
        </li>
        <li class="nav-item col-md-4" role="presentation">
            <a class="nav-link" id="travels-rating-tab" data-toggle="tab" href="#travels-rating" role="tab"
               aria-controls="profile"
               aria-selected="false">Походы</a>
        </li>
        <li class="nav-item col-md-4" role="presentation">
            <a class="nav-link" id="articles-rating-tab" data-toggle="tab" href="#articles-rating" role="tab"
               aria-controls="profile" aria-selected="false">Статьи</a>
        </li>
    </ul>

    <div class="tab-content mt-3" id="myTabContent">
        <div class="tab-pane fade show active" id="points-rating" role="tabpanel" aria-labelledby="points-rating-tab">
            {{--            <div class="card" id="rating-card">--}}
            {{--                <div class="card-body p-0">--}}
            {{--                    <ul class="list-group list-group-flush">--}}
            {{--                        <li class="list-group-item border-0 font-weight-bold">--}}
            {{--                            <div class="row">--}}
            {{--                                <div class="col-md-1">#</div>--}}
            {{--                                <div class="col-md-2">Фамилия, имя</div>--}}
            {{--                                <div class="col-md-3">Очки</div>--}}
            {{--                                <div class="col-md-6 text-right">--}}
            {{--                                    <a href="#">--}}
            {{--                                        <i class="fas fa-cog"></i>--}}
            {{--                                    </a>--}}
            {{--                                </div>--}}
            {{--                            </div>--}}
            {{--                        </li>--}}

            {{--                        <rating-row></rating-row>--}}
            {{--                        <rating-row></rating-row>--}}
            {{--                        <rating-row></rating-row>--}}
            {{--                    </ul>--}}
            {{--                </div>--}}
            {{--            </div>--}}

            <rating></rating>
        </div>

        <div class="tab-pane fade" id="travels-rating" role="tabpanel" aria-labelledby="travels-rating-tab">2</div>
        <div class="tab-pane fade" id="articles-rating" role="tabpanel" aria-labelledby="articles-rating-tab">3</div>
    </div>
@endsection
