<template>
    <div class="row">
        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-body h-100 p-3">
                    <div class="h-100 text-center d-flex flex-column">
                        <canvas id="categoriesChart" class=""></canvas>

                        <div class="small text-secondary mb-1 mt-auto">
                            очков за категории
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-8 mt-3 mt-lg-0 mh-100">
            <div class="card">
                <div class="card-body p-3">
                    <div class="text-center d-flex flex-column">
                        <canvas id="pointsChart" class="w-100"></canvas>

                        <div class="small text-secondary mb-1 mt-auto">
                            очков за месяцы
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import statisticsApi from '../../../api/statistics'
import {Chart, registerables} from 'chart.js'
import '../../../libraries/ChartjsDayjsAdapter'

Chart.register(...registerables);

export default {
    props: [
        'first',
        'second'
    ],
    data() {
        return {
            points: [],
            categories: [],
            names: []
        }
    },
    created() {
        statisticsApi.loadCompareData({
            first: this.first,
            second: this.second
        }).then((response) => {
            this.points = response.data.points
            this.categories = response.data.categories
            this.names = response.data.names

            if (this.points) {
                this.drawPointsChart()
                this.drawCategoriesChart()
            }
        })
    },
    methods: {
        drawPointsChart() {
            let ctx = document.getElementById('pointsChart').getContext('2d');
            let pointsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: [{
                        label: this.names[this.first],
                        data: this.points[this.first],
                        fill: false,
                        borderColor: '#0275d8',
                        tension: 0.1
                    }, {
                        label: this.names[this.second],
                        data: this.points[this.second],
                        fill: false,
                        borderColor: '#ffc107',
                        tension: 0.1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: true,
                        },
                        tooltip: {
                            bodyAlign: 'center',
                            displayColors: false,
                            callbacks: {
                                title: (context) => {
                                    return this.$date(context[0].parsed.x).format('MMMM YYYY')
                                },
                                label: function (context) {
                                    return context.formattedValue + ' очков'
                                },
                            }
                        }
                    },
                    parsing: {
                        xAxisKey: 'date',
                        yAxisKey: 'amount'
                    },
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'month'
                            }
                        }
                    }
                }
            });
        },
        drawCategoriesChart() {
            let ctx = document.getElementById('categoriesChart').getContext('2d');
            let categoriesChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        this.names[this.first],
                        this.names[this.second]
                    ],
                    datasets: this.categories.map((c) => {
                        return {
                            label: c.category.name,
                            data: [
                                this.first in c.data ? c.data[this.first] : 0,
                                this.second in c.data ? c.data[this.second] : 0,
                            ],
                            backgroundColor: c.category.color,
                        }
                    })
                },
                options: {
                    responsive: true,
                    aspectRatio: 1,
                    scales: {
                        xAxes: {stacked: true},
                        yAxes: {stacked: true}
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        }
    }
}
</script>
