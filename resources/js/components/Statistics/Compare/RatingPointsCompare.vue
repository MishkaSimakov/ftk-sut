<template>
    <div class="card">
        <div class="card-body p-3">
            <div class="h-100 text-center d-flex flex-column">
                <canvas id="pointsChart" class="w-100"></canvas>

                <div class="small text-secondary mb-1 mt-auto">
                    очков за месяцы
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
            names: []
        }
    },
    created() {
        statisticsApi.loadCompareData({
            first: this.first,
            second: this.second
        }).then((response) => {
            this.loading = false

            this.points = response.data.points
            this.names = response.data.names

            if (this.points.length) {
                this.drawPointsChart()
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
                        label: this.names[0],
                        data: this.points[0],
                        fill: false,
                        borderColor: '#ffc107',
                        tension: 0.1
                    }, {
                        label: this.names[1],
                        data: this.points[1],
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
        }
    }
}
</script>
