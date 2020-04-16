@extends('layouts.page')

@section('content')
    <div class="container mt-3">
        <div class="row">
            <div class="col-lg-4 mb-2">
                <div class="card">
                    <div>
                        <img class="card-img-top" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAT4AAACfCAMAAABX0UX9AAAACVBMVEWrq6usrKyxsbEOiQTEAAAAVklEQVR4nO3SQREAIAzAsA3/ohHRBw8SCb3OIRiSJZAveT0/AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAABfWYILY40GN7VsZI8AAAAASUVORK5CYII=" alt="Card image cap">
                        <a style="cursor: pointer;" data-toggle="modal" data-target="#photo-edit-modal" class="text-gray-600" title="Редактировать фото">
                            <i
                                class="fas fa-camera position-relative h2"
                                style="left: calc(100% - 1.8rem - 5px); top: calc(-1.8rem - 5px)"
                            >
                            </i>
                        </a>
                    </div>

                    <div class="card-body">
                        <h4 class="card-title text-center">{{ $user->name }}</h4>

{{--                        @auth--}}
{{--                            <new-chat-button recipients="{{ $user->toJSON() }}"></new-chat-button>--}}
{{--                        @endauth--}}
                        <a href="{{ route('settings.show') }}">
                            <button class="btn btn-outline-primary w-100">
                                Настройки аккаунта
                            </button>
                        </a>

                        <hr>
                        <p class="card-text">{!! $user->description ?? 'Здесь ничего нет!' !!}</p>
                    </div>

                    <div class="card-footer">
                        <a class="h3" href="https://vk.com/simakovkin"><i class="fab fa-vk"></i></a>
                        <a class="ml-2 h3" href="https://vk.com/simakovkin"><i class="fab fa-instagram"></i></a>
                        <a class="ml-2 h3" href="tel:+79897091484"><i class="fas fa-phone"></i></a>
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
                        @component('components.card-lists.articles', ['articles' => $user->articles()->where('is_published', true)->get()->sortByDesc('points')])@endcomponent
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

{{--    <h1 class="text-center m-2">{{ $user->name }}</h1>--}}

{{--    <div class="container">--}}
{{--        <div class="card-deck">--}}
{{--            @if ($user->student)--}}
{{--                <div class="col-md-6 col-sm-11 mb-4">--}}
{{--                    <div class="card border-left-info shadow h-100 py-2">--}}
{{--                        <div class="card-body">--}}
{{--                            <div class="row no-gutters align-items-center">--}}
{{--                                <div class="col mr-2">--}}
{{--                                    <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Достижения</div>--}}
{{--                                    <div class="row no-gutters align-items-center">--}}
{{--                                        <div class="col-auto">--}}
{{--                                            <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800" style="color: #5a5c69 !important;">{{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="col">--}}
{{--                                            <div class="progress progress-sm mr-2">--}}
{{--                                                <div class="progress-bar bg-info" role="progressbar" style="width: {{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%"></div>--}}
{{--                                            </div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-auto">--}}
{{--                                    <i class="fas fa-trophy fa-2x text-gray-300" style="color: #dddfeb !important;"></i>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}

{{--            <div class="col-md-6 col-sm-11 mb-4">--}}
{{--                <div class="card border-left-success shadow h-100 py-2">--}}
{{--                    <div class="card-body">--}}
{{--                        <div class="row no-gutters align-items-center">--}}
{{--                            <div class="col mr-2">--}}
{{--                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Статьи</div>--}}
{{--                                <div class="row no-gutters align-items-center">--}}
{{--                                    <div class="col">--}}
{{--                                        <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $user->articles->count() }}</div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="col-auto">--}}
{{--                                <i class="fas fa-newspaper fa-2x text-gray-300" style="color: #dddfeb !important;"></i>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            --}}{{--            TODO: Добавить ещё 2 таких блока и придумать, что в них писать --}}
{{--            --}}{{--            <div class="col-xl-3 col-md-6 mb-4">--}}
{{--            --}}{{--                <div class="card border-left-secondary shadow h-100 py-2">--}}
{{--            --}}{{--                    <div class="card-body">--}}
{{--            --}}{{--                        <div class="row no-gutters align-items-center">--}}
{{--            --}}{{--                            <div class="col mr-2">--}}
{{--            --}}{{--                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Статьи</div>--}}
{{--            --}}{{--                                <div class="row no-gutters align-items-center">--}}
{{--            --}}{{--                                    <div class="col-auto">--}}
{{--            --}}{{--                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%</div>--}}
{{--            --}}{{--                                    </div>--}}
{{--            --}}{{--                                    <div class="col">--}}
{{--            --}}{{--                                        <div class="progress progress-sm mr-2">--}}
{{--            --}}{{--                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%"></div>--}}
{{--            --}}{{--                                        </div>--}}
{{--            --}}{{--                                    </div>--}}
{{--            --}}{{--                                </div>--}}
{{--            --}}{{--                            </div>--}}
{{--            --}}{{--                            <div class="col-auto">--}}
{{--            --}}{{--                                <i class="fas fa-trophy fa-2x text-gray-300"></i>--}}
{{--            --}}{{--                            </div>--}}
{{--            --}}{{--                        </div>--}}
{{--            --}}{{--                    </div>--}}
{{--            --}}{{--                </div>--}}
{{--            --}}{{--            </div>--}}

{{--            --}}{{--            <div class="col-xl-3 col-md-6 mb-4">--}}
{{--            --}}{{--                <div class="card border-left-secondary shadow h-100 py-2">--}}
{{--            --}}{{--                    <div class="card-body">--}}
{{--            --}}{{--                        <div class="row no-gutters align-items-center">--}}
{{--            --}}{{--                            <div class="col mr-2">--}}
{{--            --}}{{--                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Статьи</div>--}}
{{--            --}}{{--                                <div class="row no-gutters align-items-center">--}}
{{--            --}}{{--                                    <div class="col-auto">--}}
{{--            --}}{{--                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%</div>--}}
{{--            --}}{{--                                    </div>--}}
{{--            --}}{{--                                    <div class="col">--}}
{{--            --}}{{--                                        <div class="progress progress-sm mr-2">--}}
{{--            --}}{{--                                            <div class="progress-bar bg-info" role="progressbar" style="width: {{ round($user->student->achievements->count() / \App\Achievement::all()->count() * 100) }}%"></div>--}}
{{--            --}}{{--                                        </div>--}}
{{--            --}}{{--                                    </div>--}}
{{--            --}}{{--                                </div>--}}
{{--            --}}{{--                            </div>--}}
{{--            --}}{{--                            <div class="col-auto">--}}
{{--            --}}{{--                                <i class="fas fa-trophy fa-2x text-gray-300"></i>--}}
{{--            --}}{{--                            </div>--}}
{{--            --}}{{--                        </div>--}}
{{--            --}}{{--                    </div>--}}
{{--            --}}{{--                </div>--}}
{{--            --}}{{--            </div>--}}
{{--        </div>--}}

{{--        <div class="card-deck mb-4">--}}
{{--            @if ($user->description)--}}
{{--                <div class="col">--}}
{{--                    <div class="card shadow">--}}
{{--                        <div class="card-header">--}}
{{--                            <h4 class="font-weight-bold text-primary">О себе</h4>--}}
{{--                        </div>--}}

{{--                        <div class="card-body">--}}
{{--                            {!! $user->description !!}--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}

{{--            @if (!$user->articles->isEmpty())--}}
{{--                <div class="col">--}}
{{--                    <div class="card shadow">--}}
{{--                        <div class="card-header">--}}
{{--                            <h4 class="font-weight-bold text-primary">Статьи</h4>--}}
{{--                        </div>--}}

{{--                        <div class="card-body">--}}
{{--                            @foreach($user->articles as $article)--}}
{{--                                <h5><a href="{{ $article->url }}">{{ $article->title }}</a></h5>--}}
{{--                            @endforeach--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}

{{--        <div class="card-deck mb-4">--}}
{{--            @if ($achievements)--}}
{{--                <div class="col">--}}
{{--                    <div class="card shadow">--}}
{{--                        <div class="card-header">--}}
{{--                            <h4 class="font-weight-bold text-primary">Достижения</h4>--}}
{{--                        </div>--}}

{{--                        <div class="card-body">--}}
{{--                            @component('components.card-lists.achievements', ['achievements' => $achievements])@endcomponent--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            @endif--}}
{{--        </div>--}}

{{--        <div class="card-deck mb-4">--}}
{{--            <div class="col-md-7 col-sm-11">--}}
{{--                <div class="card shadow">--}}
{{--                    <div class="card-header">--}}
{{--                        <h4 class="font-weight-bold text-primary">Очки в рейтинге</h4>--}}
{{--                    </div>--}}

{{--                    <div class="card-body">--}}
{{--                        <canvas id="point_stats" width="100" height="250">Где-то здесь должен быть график</canvas>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}

{{--            <div class="col-md-5 col-sm-11">--}}
{{--                <div class="card shadow">--}}
{{--                    <div class="card-header">--}}
{{--                        <h4 class="font-weight-bold text-primary">Очки за категории</h4>--}}
{{--                    </div>--}}

{{--                    <div class="card-body">--}}
{{--                        <canvas id="categories_stats" width="100" height="250">Где-то здесь должен быть график</canvas>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}




    <div class="modal" tabindex="-1" role="dialog" id="photo-edit-modal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Изменить фото</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div id="tui-image-editor-container"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary">Сохранить</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Отмена</button>
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
