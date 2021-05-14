<template>
    <div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="spinner-border text-primary spinner-border-sm my-2" role="status"
                                 v-if="loading"></div>
                            <div class="mb-0 font-weight-bold text-primary h2" v-else>
                                {{ totalPoints }}
                            </div>
                            <div class="small text-secondary mb-1">
                                очков за всё время
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-3 mt-md-0">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="spinner-border text-info spinner-border-sm my-2" role="status"
                                 v-if="loading"></div>
                            <div class="mb-0 font-weight-bold text-info h2" v-else>
                                {{ lastMonthPoints }}
                            </div>
                            <div class="small text-info mb-1">
                                очков за последний месяц
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-3 mt-md-0">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="spinner-border text-secondary spinner-border-sm my-2" role="status"
                                 v-if="loading"></div>
                            <div class="mb-0 font-weight-bold text-secondary h2" v-else>
                                {{ averageMonthPoints }}
                            </div>
                            <div class="small text-secondary mb-1">
                                очков в среднем за месяц
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card h-100">
                    <div class="card-body p-3">
                        <div class="h-100 text-center d-flex flex-column">
                            <canvas id="categoriesChart" class="w-100"></canvas>

                            <div class="small text-secondary mb-1 mt-auto">
                                категории очков
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mt-3 mt-md-0">
                <div class="card h-100">
                    <div class="card-body p-3">
                        <div class="h-100 text-center d-flex flex-column">
                            <canvas id="pointsChart" class="w-100"></canvas>

                            <div class="small text-secondary mb-1 mt-auto">
                                очков за месяцы
                            </div>
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
import '../../libraries/ChartjsDayjsAdapter'

Chart.register(...registerables);

export default {
    props: [
        'user'
    ],
    data() {
        return {
            loading: true,

            pointsByMonth: [],
            pointsByCategories: []
        }
    },
    computed: {
        totalPoints: function () {
            return this.pointsByMonth.length ? this.pointsByMonth.reduce((a, b) => a + parseInt(b.amount), 0) : 0
        },
        lastMonthPoints: function () {
            return this.pointsByMonth.length ? this.pointsByMonth[this.pointsByMonth.length - 1].amount : 0
        },
        averageMonthPoints: function () {
            return this.pointsByMonth.length ? Math.floor(this.pointsByMonth.reduce((a, b) => a + parseInt(b.amount), 0) / this.pointsByMonth.length) : 0
        },
    },
    created() {
        statisticsApi.loadRatingPointsStatistics({
            user: this.user
        }).then((response) => {
            this.loading = false

            this.pointsByMonth = response.data.pointsByMonth
            this.pointsByCategories = response.data.pointsByCategories

            if (this.pointsByMonth.length) {
                this.drawPointsChart()
                this.drawCategoriesChart()
            }
        })
    },
    methods: {
        drawCategoriesChart() {
            let ctx = document.getElementById('categoriesChart').getContext('2d');
            let categoriesChart = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: this.pointsByCategories.map((c) => c.category.name),
                    datasets: [{
                        data: this.pointsByCategories.map((c) => c.amount),
                        backgroundColor: this.pointsByCategories.map((c) => c.category.color),
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
                                    if (context[0].label.length > 40) {
                                        return context[0].label.substr(0, 40) + '...'
                                    }
                                    return context[0].label
                                },
                                label: function (context) {
                                    return context.parsed + ' очков'
                                },
                            }
                        }
                    }
                }
            });
        },
        drawPointsChart() {
            let ctx = document.getElementById('pointsChart').getContext('2d');
            let pointsChart = new Chart(ctx, {
                type: 'line',
                data: {
                    datasets: [{
                        label: "очки в рейтинге",
                        data: this.pointsByMonth,
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

<style scoped>

</style>
