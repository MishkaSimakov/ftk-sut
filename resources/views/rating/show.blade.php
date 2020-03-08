@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">{{ $rating->name }}</h1>

    <div class="mx-3 d-sm-block d-md-block d-lg-none d-xl-none">
        <div class="alert alert-info alert-dismissible fade show" role="contentinfo">
            🚧 Рейтинг плохо оптимизирован для маленьких экранов. Мы уже работаем над этим. 🚧
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    </div>

    <div style="display: flex;" id="loader" class="mt-5 justify-content-center">
        <div class="text-gray-600 spinner-border" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only"></span>
        </div>

        <span class="text-gray-600 ml-3 my-auto h3">
            <strong>Загрузка...</strong><br>
        </span>
    </div>

    <div style="visibility: hidden" id="rating_chart"></div>

    <div class="d-none" id="names"></div>

{{--    <canvas id="rating_chart">Где-то здесь должен быть график</canvas>--}}
@endsection

@push('script')
    <script>
        google.charts.load('current', {packages: ['corechart']});
        google.charts.setOnLoadCallback(loadChart);

        function loadChart() {
            $.ajax({
                url: "{{ route('api.rating.chart') }}",
                method: "GET",
                dataType: 'json',
                data: {
                    date: '{{ $rating->date->format('Y-m-d') }}',
                },
                success: function (data) {
                    var chart_data = [];
                    var user_data = [];

                    data.forEach(function(value) {
                        chart_data.push(value.slice(0, 20));
                        user_data.push(value.slice(20));
                    });

                    $( "#rating_chart" ).animate({
                        height: chart_data.length * 25
                    }, 1000, function () {
                        add_users(user_data);
                        drawChart(chart_data);
                    });
                }
            })
        }

        function add_users(user_data) {
            user_data.forEach(function (user) {
                $('#names').append('<span data-id=' + user[0][0] + ' data-link=' + user[0][2] + '>' + user[0][1] + '</span>')
            })
        }

        function changeNames() {
            $($('text:contains("us|")').get().reverse()).each(function(index) {
                var user_id = $(this).html().split('|')[1];

                var user = $('span[data-id=' + user_id + ']')

                if ($(window).width() < 1000) {
                    var short_name = user.html().split(' ')[0] + ' ' + user.html().split(' ')[1].substr(0, 1) + '.'

                    $(this).html('<a href=' + user.attr('data-link') + '>' + short_name + '</a>');
                } else {
                    $(this).html((index + 1) + ' <a href=' + user.attr('data-link') + '>' + user.html() + '</a>');
                }

                $(this).attr('text-anchor', 'start').attr('x', '5%')
            });

            $('#loader').hide();
            $('#rating_chart').attr('style', 'visibility: visible;');
        }

        function drawChart(chart_data) {
            var chartData = new google.visualization.DataTable();

            chartData.addColumn('string', 'Имя');

            @foreach ($categories as $category)
                chartData.addColumn('number', '{{ $category->title }}');
                chartData.addColumn({'type': 'string', 'role': 'style'}, '');
            @endforeach

            chartData.addColumn({'type': 'number', 'role': 'annotation'}, '');

            chartData.addRows(chart_data);

            //chart options
            let options = {
                fontSize: 19,
                vAxis: {
                    title: '',
                    direction: -1,
                },
                tooltip: {
                    trigger: 'none',
                },
                height: chart_data.length * 25,
                bars: 'horizontal',
                bar: {
                    groupWidth: '60%'
                },
                isStacked: true,
                colors: ['#ff0000', '#ffff00', '#000080', '#ff00ff', '#993366', '#ffffcc', '#ccffff', '#00ff00', '#ff8080'],
                hAxis: {
                    gridlines: {
                        color: 'transparent'
                    },
                },
                backgroundColor: 'transparent',
                annotations: {
                    alwaysOutside: true,

                    textStyle: {
                        fontSize: 15,
                        bold: true,
                        fontName: 'Nunito, sans-serif',
                        color: '#212529'
                    },
                }
            };

            if ($(window).width() < 1000) {
                options.chartArea = {left: 100, bottom: 25, top: 0, width:"100%"};
                options.height = chart_data.length * 85;
                options.bar = {groupWidth: '50%'};
            } else {
                options.chartArea = {left: 300, bottom: 25, top: 0, width: "50%"};
                options.legend = {
                    maxLines: 2,
                    position: 'right',
                    alignment: 'start'
                };
            }

            let chart = new google.visualization.BarChart(document.getElementById('rating_chart'));

            google.visualization.events.addListener(chart, 'ready', changeNames);

            chart.draw(chartData, options);
        }
    </script>
@endpush

{{--@push('script')--}}
{{--    <script>--}}
{{--        $.ajax({--}}
{{--            url: "{{ route('api.rating.chart') }}",--}}
{{--            method: "GET",--}}
{{--            dataType: 'json',--}}
{{--            data: {--}}
{{--                date: '{{ $rating->date->format('Y-m-d') }}',--}}
{{--            },--}}
{{--            success: function (data) {--}}
{{--                $('#rating_chart').attr('height', (data[0].length * 5).toString() + "px")--}}

{{--                drawChart(data)--}}
{{--            }--}}
{{--        });--}}

{{--        function getRandomColor() {--}}
{{--            var letters = '0123456789ABCDEF';--}}
{{--            var color = '#';--}}
{{--            for (var i = 0; i < 6; i++) {--}}
{{--                color += letters[Math.floor(Math.random() * 16)];--}}
{{--            }--}}
{{--            return color;--}}
{{--        }--}}

{{--        function drawChart(data) {--}}
{{--            var ctx = document.getElementById('rating_chart').getContext('2d');--}}

{{--            var datasets = [];--}}

{{--            $.each(data[1], function (key, values) {--}}
{{--                datasets.push({--}}
{{--                    barPercentage: 0.5,--}}
{{--                    barThickness: 6,--}}
{{--                    maxBarThickness: 8,--}}
{{--                    minBarLength: 2,--}}

{{--                    label: key,--}}
{{--                    backgroundColor: getRandomColor(),--}}
{{--                    data: values,--}}
{{--                })--}}
{{--            });--}}

{{--            var chart = new Chart(ctx, {--}}
{{--                type: 'horizontalBar',--}}
{{--                data: {--}}
{{--                    labels: data[0],--}}
{{--                    datasets: datasets--}}
{{--                },--}}
{{--                options: {--}}
{{--                    scales: {--}}
{{--                        yAxes: [{--}}
{{--                            stacked: true,--}}
{{--                            gridLines: {--}}
{{--                                display:false--}}
{{--                            }--}}
{{--                        }],--}}
{{--                        xAxes: [{--}}
{{--                            gridLines: {--}}
{{--                                display:false--}}
{{--                            }--}}
{{--                        }]--}}
{{--                    },--}}
{{--                    legend: {--}}
{{--                        // position: 'right',--}}
{{--                        // align: 'start'--}}
{{--                        display: false,--}}
{{--                    },--}}
{{--                    tooltips: {--}}
{{--                        backgroundColor: "rgb(255,255,255)",--}}
{{--                        bodyFontColor: "#858796",--}}
{{--                        titleMarginBottom: 10,--}}
{{--                        titleFontColor: '#6e707e',--}}
{{--                        titleFontSize: 14,--}}
{{--                        borderColor: '#dddfeb',--}}
{{--                        borderWidth: 1,--}}
{{--                        xPadding: 15,--}}
{{--                        yPadding: 15,--}}
{{--                        displayColors: false,--}}
{{--                        intersect: false,--}}
{{--                        mode: 'index',--}}
{{--                        caretPadding: 10,--}}
{{--                    }--}}
{{--                }--}}
{{--            });--}}
{{--        }--}}
{{--    </script>--}}
{{--@endpush--}}
