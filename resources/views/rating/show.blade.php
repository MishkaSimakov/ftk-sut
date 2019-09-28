@include('partials.header')

<h1 class="text-center m-2">{{ $rating->name }}</h1>

<div id="rating_chart" style="max-width: 97%"></div>

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

            chartData.addColumn('number', 'Посещение занятий');
            chartData.addColumn({'type': 'string', 'role': 'style'}, '');

            chartData.addColumn('number', 'Игры, конкурсы в клубе');
            chartData.addColumn({'type': 'string', 'role': 'style'}, '');

            chartData.addColumn('number', 'Газета, группа ВК');
            chartData.addColumn({'type': 'string', 'role': 'style'}, '');

            chartData.addColumn('number', 'Походы и экскурсии');
            chartData.addColumn({'type': 'string', 'role': 'style'}, '');

            chartData.addColumn('number', 'Городские соревнования, выставки, конкурсы');
            chartData.addColumn({'type': 'string', 'role': 'style'}, '');

            chartData.addColumn('number', 'Областные, всероссийские, международные соревнования');
            chartData.addColumn({'type': 'string', 'role': 'style'}, '');

            chartData.addColumn({'type': 'number', 'role': 'annotation'}, '');

            chartData.addRows(data);

            if ($(window).width() < 1000) {
                console.log($(window).width());

                var options = {
                    vAxis: {
                      title: '',
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
                    colors: ['#9999ff', '#993366', '#ffffcc', '#ccffff', '#00ff00', '#ff8080'],
                    chartArea: {left: 250, bottom: 0, top: 0, width:"100%"},
                    hAxis: {
                        gridlines: {
                            color: 'transparent'
                        }
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
            } else {
                var options = {
                    vAxis: {
                      title: '',
                    },
                    tooltip: {
                        trigger: 'none',
                    },
                    legend: {
                        maxLines: 2,
                        position: 'right',
                        alignment: 'start'
                    },
                    height: data.length * 25,
                    bars: 'horizontal',
                    bar: {
                        groupWidth: '60%'
                    },
                    isStacked: true,
                    colors: ['#9999ff', '#993366', '#ffffcc', '#ccffff', '#00ff00', '#ff8080'],
                    chartArea: {left: 250, bottom: 0, top: 0, width:"50%"},
                    hAxis: {
                        gridlines: {
                            color: 'transparent'
                        }
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
            }

            var chart = new google.visualization.BarChart(document.getElementById('rating_chart'));

            chart.draw(chartData, options);

            $(document).ready(function () {
                $('text:contains("us|")').each(function() {
                    var user_id = $(this).html().split('|')[1];
                    var username = $(this).html().split('|')[2];

                    $(this).html('<a style="color: #3490dc !important;" href="{{ Request::root() }}/user/' + user_id + '">' + username + '</a>');
                });
            });
        }
    </script>

@include('partials.footer')
