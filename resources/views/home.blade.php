@include('partials.header')

<h1 class="text-center m-2">Домик</h1>

@if (!$achievements->isEmpty())
    <div>
        <div class="text-center">
            <h2>Достижения</h2>

            @foreach($achievements as $achievement)
                    <div class="card m-3 d-inline-block" style="width: 18rem">
                        <img class="card-img-top" src="{{ $achievement->image_url }}" alt="Изображение от достижения">

                        <div class="card-body">
                            <h5 class="card-title">{{ $achievement->title }}</h5>
                            <p class="card-text">{{ $achievement->body }}</p>
                        </div>
                    </div>
            @endforeach
        </div>
    </div>
@endif

@if (!Auth::user()->isTeacher)
    <div>
        <h2 class="text-center">
            Статистика
        </h2>

        <div class="container">
            <div id="user_statistic_chart" class="w-100"></div>
        </div>
    </div>
@endif

<script>
    google.charts.load('current', {packages: ['corechart', 'line']});
    google.charts.setOnLoadCallback(loadChart);

    function loadChart() {
        $.ajax({
            url: "{{ route('api.home.statistic') }}",
            method: "GET",
            dataType: 'json',
            data: {
                user: '{{ Auth::user()->id }}',
            },
            success: function (data) {
                drawChart(data);
            }
        })
    }


    function drawChart(data) {
        var chartData = new google.visualization.DataTable();

        chartData.addColumn('string', 'Дата');
        chartData.addColumn('number', 'Место');

        data.forEach(function (element, index) {
            data[index][0] = new Date(element[0] * 1000).toLocaleString('ru', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        });

        console.log(data);

        chartData.addRows(data);


        var options = {
            vAxis: {
                direction: -1,
            },
            hAxis: {
                direction: -1,
                gridlines: {
                    count: 4
                },
                format: 'dd-MMMM-yyyy'
            },
            backgroundColor: 'transparent',
        };

        var chart = new google.visualization.LineChart(document.getElementById('user_statistic_chart'));

      chart.draw(chartData, options);
    }
</script>

@include('partials.footer')
