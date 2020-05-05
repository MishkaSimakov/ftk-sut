@extends('layouts.page', ['title' => $user->name])

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-4 mb-2">
                <div class="card">
                    <user-photo src="{{ $user->getMedia()->count() ? $user->getMedia()->first()->getUrl() : 'https://upload.wikimedia.org/wikipedia/commons/4/46/%D0%A1%D0%B5%D1%80%D1%8B%D0%B9_%D1%86%D0%B2%D0%B5%D1%82-_2014-03-15_18-16.jpg' }}"></user-photo>

                    <div class="card-body">
                        <h4 class="card-title text-center">{{ $user->name }}</h4>

                        @auth
                            <new-chat-button title="{{ auth()->user()->name }} - {{ $user->name }}" recipients="{{ $user->toJSON() }}"></new-chat-button>
                        @endauth

                        <hr>
                        <div class="card-text">
                            @if ($user->description)
                                {!! $user->description !!}
                            @else
                                <p>Здесь ничего нет!</p>
                            @endif
                        </div>
                    </div>

                    <div class="card-footer">
                        @if ($user->vk_link)
                            <a class="h3" href="{{ $user->vk_link }}"><i class="fab fa-vk"></i></a>
                        @endif
                        @if ($user->phone)
                            <a class="ml-2 h3" href="tel:{{ $user->phone }}"><i class="fas fa-phone"></i></a>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-lg-8">
                <div class="btn-toolbar mb-3" role="toolbar">
                    <div class="w-100 btn-group" role="group">
                        <button type="button" class="btn btn-outline-primary" onclick="changeTab(event, 'articles')">Статьи</button>
                        <button type="button" class="btn btn-outline-primary" onclick="changeTab(event, 'achievements')">Достижения</button>
                        <button type="button" class="btn btn-outline-primary active" onclick="changeTab(event, 'statistics')">Статистика</button>
                    </div>
                </div>

                <div id="tabs">
                    <div id="articles" style="display: none">
                        @component('components.card-lists.articles', ['articles' => $articles])@endcomponent

                        <div class="d-flex">
                            <div class="mx-auto">
                                {{ $articles->links() }}
                            </div>
                        </div>
                    </div>

                    <div id="achievements" style="display: none">
                        @component('components.card-lists.achievements', ['achievements' => $achievements])@endcomponent
                    </div>

                    <div id="statistics">
                        <div class="row">
                            <div class="col-lg-7 mb-2">
                                <div class="card shadow">
                                    <div class="card-header">
                                        <h4 class="font-weight-bold text-primary">Очки в рейтинге</h4>
                                    </div>

                                    <div class="card-body">
                                        <canvas id="point_stats" width="100" height="250">Где-то здесь должен быть график</canvas>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-5">
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
                            right: 40,
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
                                reverse: true,
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

    <script>
        function changeTab(evt, tabId) {
            $('#tabs').children().each(function () {
                $(this).hide();
            });

            $('.active').each(function () {
                $(this).removeClass('active');
            });

            $('#' + tabId).show();

            evt.currentTarget.className += " active";
        }
    </script>
@endpush
