<template>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="text-center">
                        <div class="spinner-border text-primary spinner-border-sm" role="status" v-if="loading"></div>
                        <div class="mb-0 font-weight-bold text-primary h2" v-else>
                            {{ totalPoints }}
                        </div>
                        <div class="small text-secondary mb-1">
                            очков за всё время
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body p-3">
                    <div class="text-center">
                        <div class="spinner-border text-secondary spinner-border-sm" role="status" v-if="loading"></div>
                        <div class="mb-0 font-weight-bold text-secondary h2" v-else>
                            {{ this.points[this.points.length - 1].amount }}
                        </div>
                        <div class="small text-secondary mb-1">
                            очков за последний месяц
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body p-3">
                    <div class="text-center">
                        <div class="small text-secondary mb-1">
                            категории очков
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-8">
            <div class="card">
                <div class="card-body p-3">
                    <div class="text-center">
                        <canvas id="pointsChart" class="h-100 w-100"></canvas>

                        <div class="small text-secondary mb-1">
                            очков за месяцы
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import statisticsApi from '../../api/statistics'
import {Chart, registerables} from 'chart.js'
import 'chartjs-adapter-moment';

export default {
    props: [
        'user'
    ],
    data() {
        return {
            loading: true,

            points: []
        }
    },
    computed: {
        totalPoints: function () {
            return this.points.reduce((a, b) => a + parseInt(b.amount), 0)
        }
    },
    created() {
        statisticsApi.loadRatingPointsStatistics({
            user: this.user
        }).then((response) => {
            this.loading = false

            this.points = response.data
            this.drawChart()
        })
    },
    methods: {
        drawChart() {
            Chart.register(...registerables);

            let ctx = document.getElementById('pointsChart').getContext('2d');
            let pointsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: [{
                        label: "очки в рейтинге",
                        data: this.points,
                        fill: false,
                        borderColor: '#ffc107',
                        tension: 0.1
                    }]
                },
                options: {
                    plugins: {
                        legend: {
                            display: false,
                        },
                        tooltip: {
                            bodyAlign: 'center',
                            displayColors: false,
                            callbacks: {
                                title: function (context) {
                                    return Vue.moment(context[0].parsed.x).format('MMMM YYYY')
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

<style scoped>

</style>
