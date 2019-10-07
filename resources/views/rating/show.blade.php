@include('partials.header')

<h1 class="text-center m-2">{{ $rating->name }}<i title="фильтр" id="filter" style="font-size: 1.5rem; cursor: pointer" class="float-right text-primary ml-2 fa-xs fas fa-filter"></i></h1>

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
            colors: ['#9999ff', '#993366', '#ffffcc', '#ccffff', '#00ff00', '#ff8080'],
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
            options.chartArea = {left: 300, bottom: 0, top: 0, width:"100%"};
        } else {
            options.chartArea = {left: 300, bottom: 0, top: 0, width: "50%"};
            options.legend = {
                maxLines: 2,
                position: 'right',
                alignment: 'start'
            };
        }

        let chart = new google.visualization.BarChart(document.getElementById('rating_chart'));

        chart.draw(chartData, options);

        $(document).ready(function () {
            $('text:contains("us|")').each(function() {
                var user_id = $(this).html().split('|')[1];
                var username = $(this).html().split('|')[2];

                $(this).html('<a style="color: #3490dc !important;" href="{{ Request::root() }}/user/' + user_id + '">' + username + '</a>');
            });
        });
    }

    $('#filter').on('click', function () {
        $('#modal_filter').modal('show');
    });
</script>

<div class="modal fade" id="modal_filter" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Фильтры</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <div class="container">
                    <form method="GET" action="{{ route('rating.show', compact('rating')) }}">
                        <fieldset class="form-group" style="overflow: auto; overflow-x: hidden;">
                            <div class="row">
                                <legend class="col-form-label col-sm-2 pt-0">Показать только</legend>
                                <div class="col-sm-10">
                                    @foreach($rating->points->sortBy('user.name') as $point)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="user" id="user" value="{{ $point->user->id }}">
                                            <label class="form-check-label" for="user">
                                                {{ $point->user->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </fieldset>

{{--                        <p>--}}
{{--                            показать очки только за--}}
{{--                            <a href="{{ route('rating.show', compact('rating')) }}?only=lesson">--}}
{{--                                Посещение занятий--}}
{{--                            </a>--}}
{{--                            /--}}
{{--                            <a href="{{ route('rating.show', compact('rating')) }}?only=games">--}}
{{--                                Игры, конкурсы в клубе--}}
{{--                            </a>--}}
{{--                            /--}}
{{--                            <a href="{{ route('rating.show', compact('rating')) }}?only=press">--}}
{{--                                Газета, группа ВК--}}
{{--                            </a>--}}
{{--                            /--}}
{{--                            <a href="{{ route('rating.show', compact('rating')) }}?only=travel">--}}
{{--                                Походы и экскурсии--}}
{{--                            </a>--}}
{{--                            /--}}
{{--                            <a href="{{ route('rating.show', compact('rating')) }}?only=local_competition">--}}
{{--                                Городские соревнования, выставки, конкурсы--}}
{{--                            </a>--}}
{{--                            /--}}
{{--                            <a href="{{ route('rating.show', compact('rating')) }}?only=global_competition">--}}
{{--                                Областные, всероссийские,--}}
{{--                                международные соревнования--}}
{{--                            </a>--}}
{{--                        </p>--}}

                        <input type="submit" value="Отправить">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@include('partials.footer')
