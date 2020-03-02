@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">{{ $rating->name }}</h1>

    <div style="display: block;" id="rating_chart"></div>

    <div style="display: flex;" id="loader" class="mt-5 justify-content-center">
        <div class="text-gray-600 spinner-border" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only"></span>
        </div>

        <span class="text-gray-600 ml-3 my-auto h3">
            <strong>Загрузка...</strong><br>
        </span>
    </div>

    <div class="d-none" id="names">

    </div>
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

                    add_users(user_data)
                    drawChart(chart_data)
                }
            })
        }

        function add_users(user_data) {
            user_data.forEach(function (user) {
                $('#names').append('<span data-id=' + user[0][0] + ' data-link=' + user[0][2] + '>' + user[0][1] + '</span>')
            })
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

            $('#loader').hide("slow");

            chart.draw(chartData, options);

            $(document).ready(function () {
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
            });
        }
    </script>
@endpush
