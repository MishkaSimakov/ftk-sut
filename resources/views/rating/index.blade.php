@extends('layouts.page')

@section('content')

    <h1 class="text-center m-2">Рейтинг</h1>

    <div class="container">
        @admin
            <div class="mb-2 card shadow w-100">
                <div class="card-body py-2 row">
                    <a href="{{ route('rating.create') }}" class="ml-2 font-weight-bolder">
                        <i class="fas fa-plus my-auto mr-1"></i>
                        Добавить рейтинг
                    </a>
                </div>
            </div>
        @endadmin

        @foreach($ratings as $year => $year_ratings)
            <div id="{{ $year }}" class="card mb-2">
                <div class="card-body">
                    <div class="row no-gutters d-flex flex-grow-1">
                        <h3 class="card-title font-weight-bolder mx-auto"><span class="d-none d-sm-inline">Учебный год</span> {{ $year }}</h3>

                        @if(now()->isAfter(
                            now()->setYear(explode('-', $year)[1])->setMonth(5)
                        ))
                            <i class="mt-1 fa fa-check-circle position-absolute text-success" data-toggle="tooltip" data-title="Этот учебный год завершён!"></i>
                        @endif
                    </div>

                    <ul class="list-unstyled mb-0">
                        @foreach($year_ratings as $rating)
                            <li>
                                @if ($rating->type === 'yearly')
                                    <a class="font-weight-bolder h5" href="{{ $rating->url }}">{{ $rating->name }}</a>
                                @else
                                    <a href="{{ $rating->url }}">{{ $rating->name }}</a>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endforeach
    </div>


{{--        <h2 class="ml-2"><a href="{{ $rating->url }}">{{ $rating->name }}</a></h2>--}}

@endsection

@push('side')
    <div class="card mt-2">
        <div class="card-body">
            <ul class="list-unstyled mb-0">
                @foreach($ratings as $year => $value)
                    <li><a href="#{{ $year }}"><i class="fas fa-calendar-alt mr-2"></i>Учебный год {{ $year }}</a></li>
                @endforeach
            </ul>
        </div>
    </div>
@endpush

@push('script')
    <script>
        $(document).ready(function () {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            })
        })
    </script>
@endpush
