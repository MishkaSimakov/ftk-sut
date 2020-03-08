@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">{{ $user->name }}</h1>

    <div class="container">
        <div class="card-deck">
            <div class="col-md-6 col-sm-11 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Достижения</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" style="color: #5a5c69 !important;">{{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%</div>
                                    </div>
                                    <div class="col">
                                        <div class="progress progress-sm mr-2">
                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-trophy fa-2x text-gray-300" style="color: #dddfeb !important;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-sm-11 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Статьи</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col">
                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $user->articles->count() }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-newspaper fa-2x text-gray-300" style="color: #dddfeb !important;"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

{{--            TODO: Добавить ещё 2 таких блока и придумать, что в них писать --}}
{{--            <div class="col-xl-3 col-md-6 mb-4">--}}
{{--                <div class="card border-left-secondary shadow h-100 py-2">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row no-gutters align-items-center">--}}
{{--                            <div class="col mr-2">--}}
{{--                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Статьи</div>--}}
{{--                                <div class="row no-gutters align-items-center">--}}
{{--                                    <div class="col-auto">--}}
{{--                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%</div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col">--}}
{{--                                        <div class="progress progress-sm mr-2">--}}
{{--                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto">--}}
{{--                                <i class="fas fa-trophy fa-2x text-gray-300"></i>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-xl-3 col-md-6 mb-4">--}}
{{--                <div class="card border-left-secondary shadow h-100 py-2">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row no-gutters align-items-center">--}}
{{--                            <div class="col mr-2">--}}
{{--                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Статьи</div>--}}
{{--                                <div class="row no-gutters align-items-center">--}}
{{--                                    <div class="col-auto">--}}
{{--                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%</div>--}}
{{--                                    </div>--}}
{{--                                    <div class="col">--}}
{{--                                        <div class="progress progress-sm mr-2">--}}
{{--                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%"></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto">--}}
{{--                                <i class="fas fa-trophy fa-2x text-gray-300"></i>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>

        <div class="card-deck mb-4">
            @if ($user->description)
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4 class="font-weight-bold text-primary">О себе</h4>
                        </div>

                        <div class="card-body">
                            {!! $user->description !!}
                        </div>
                    </div>
                </div>
            @endif

            @if (!$user->articles->isEmpty())
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4 class="font-weight-bold text-primary">Статьи</h4>
                        </div>

                        <div class="card-body">
                            @foreach($user->articles as $article)
                                <h5><a href="{{ $article->url }}">{{ $article->title }}</a></h5>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="card-deck mb-4">
            @if ($achievements)
                <div class="col">
                    <div class="card shadow">
                        <div class="card-header">
                            <h4 class="font-weight-bold text-primary">Достижения</h4>
                        </div>

                        <div class="card-body">
                            @component('components.card-lists.achievements', ['achievements' => $achievements])@endcomponent
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <div class="card-deck mb-4">
            <div class="col-md-7 col-sm-11">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="font-weight-bold text-primary">Очки в рейтинге</h4>
                    </div>

                    <div class="card-body">
                        <canvas id="point_stats" width="100" height="250">Где-то здесь должен быть график</canvas>
                    </div>
                </div>
            </div>

            <div class="col-md-5 col-sm-11">
                <div class="card shadow">
                    <div class="card-header">
                        <h4 class="font-weight-bold text-primary">Очки за категории</h4>
                    </div>

                    <div class="card-body">
                        <canvas id="categories_stats" width="100" height="250">Где-то здесь должен быть график</canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
    <script>
        $.ajax({
            url: "{{ route('api.user.point_stats', compact('user')) }}",
            method: "GET",
            dataType: 'json',
            success: function (data) {
                drawPointChart(data)
            }
        });

        $.ajax({
            url: "{{ route('api.user.categories_stats', compact('user')) }}",
            method: "GET",
            dataType: 'json',
            success: function (data) {
                console.log(data)
                drawCategoriesChart(data)
            }
        });

        function drawPointChart(data) {
                var ctx = document.getElementById('point_stats').getContext('2d');
                var chart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: data[0],
                        datasets: [{
                            label: '# очков в рейтинге',
                            data: data[1],

                            lineTension: 0.3,
                            backgroundColor: "rgba(78, 115, 223, 0.05)",
                            borderColor: "rgba(78, 115, 223, 1)",
                            pointRadius: 3,
                            pointBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointBorderColor: "rgba(78, 115, 223, 1)",
                            pointHoverRadius: 3,
                            pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                            pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                            pointHitRadius: 10,
                            pointBorderWidth: 2,
                        }]
                    },
                    options: {
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                left: 10,
                                right: 25,
                                top: 25,
                                bottom: 0
                            }
                        },
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'date'
                                },
                                gridLines: {
                                    display: false,
                                    drawBorder: false
                                },
                                ticks: {
                                    maxTicksLimit: 7
                                }
                            }],
                            yAxes: [{
                                ticks: {
                                    maxTicksLimit: 5,
                                    padding: 10,
                                },
                                gridLines: {
                                    color: "rgb(234, 236, 244)",
                                    zeroLineColor: "rgb(234, 236, 244)",
                                    drawBorder: false,
                                    borderDash: [2],
                                    zeroLineBorderDash: [2]
                                }
                            }],
                        },
                        legend: {
                            display: false
                        },
                        tooltips: {
                            backgroundColor: "rgb(255,255,255)",
                            bodyFontColor: "#858796",
                            titleMarginBottom: 10,
                            titleFontColor: '#6e707e',
                            titleFontSize: 14,
                            borderColor: '#dddfeb',
                            borderWidth: 1,
                            xPadding: 15,
                            yPadding: 15,
                            displayColors: false,
                            intersect: false,
                            mode: 'index',
                            caretPadding: 10,
                        }
                    }
                });
        }

        function drawCategoriesChart(data) {
            var ctx = document.getElementById('categories_stats').getContext('2d');
            var chart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: data[0],
                    datasets: [{
                        label: '# очков за категорию',
                        data: data[1],

                        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#4e73df', '#1cc88a', '#36b9cc', '#4e73df', '#1cc88a', '#36b9cc'],
                        hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf', '#2e59d9', '#17a673', '#2c9faf', '#2e59d9', '#17a673', '#2c9faf'],
                        hoverBorderColor: "rgba(234, 236, 244, 1)",
                    }]
                },
                options: {
                    maintainAspectRatio: false,
                    tooltips: {
                        backgroundColor: "rgb(255,255,255)",
                        bodyFontColor: "#858796",
                        borderColor: '#dddfeb',
                        borderWidth: 1,
                        xPadding: 15,
                        yPadding: 15,
                        displayColors: false,
                        caretPadding: 10,
                    },
                    legend: {
                        display: false
                    },
                    cutoutPercentage: 80,
                }
            });
        }
    </script>
@endpush
