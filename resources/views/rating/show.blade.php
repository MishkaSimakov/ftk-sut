@extends('layouts.page')

@section('content')
    <h1 class="text-center m-2">{{ $rating->name }}</h1>

    <div id="rating_chart" style="max-width: 97%"></div>
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
                    drawChart(data)
                }
            })
        }


        function drawChart(data) {
            var chartData = new google.visualization.DataTable();

            chartData.addColumn('string', 'Имя');

            @foreach ($categories as $category)
            chartData.addColumn('number', '{{ $category->title }}');
            chartData.addColumn({'type': 'string', 'role': 'style'}, '');
            @endforeach

            chartData.addColumn({'type': 'number', 'role': 'annotation'}, '');

            chartData.addRows(data);

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
                height: data.length * 25,
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
                options.chartArea = {left: 300, bottom: 25, top: 0, width:"100%"};
            } else {
                options.chartArea = {left: 300, bottom: 25, top: 0, width: "50%"};
                options.legend = {
                    maxLines: 2,
                    position: 'right',
                    alignment: 'start'
                };
            }

            let chart = new google.visualization.BarChart(document.getElementById('rating_chart'));

            chart.draw(chartData, options);

            $(document).ready(function () {
                //TODO: исправить это недразумение

                $('text:contains("us|")').each(function() {
                    var user_id = $(this).html().split('|')[1];
                    var student_name = $(this).html().split('|')[2];

                    $(this).html('<a style="color: #3490dc !important;" href="{{ env('APP_URL') }}/user/' + user_id + '">' + student_name + '</a>');
                });
            });
        }
    </script>
@endpush
