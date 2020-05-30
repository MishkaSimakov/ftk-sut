<template>
    <div class="card shadow">
        <div class="card-header">
            <h4 class="font-weight-bold text-primary">Очки в рейтинге</h4>
        </div>

        <div class="card-body">
            <canvas id="point_stats" width="100" height="250">Где-то здесь должен быть график</canvas>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'user'
        ],
        methods: {
            drawChart(data) {
                new Chart(
                    document.getElementById('point_stats').getContext('2d'),
                    {
                        type: 'line',
                        data: {
                            labels: data[0],
                            datasets: [{
                                label: '# очков в рейтинге',
                                data: data[1],

                                lineTension: 0.3,
                                backgroundColor: "rgba(78, 115, 223, 0.05)",
                                borderColor: "rgba(78, 115, 223, 1)",
                                pointRadius: 3,
                                pointBackgroundColor: "rgba(78, 115, 223, 1)",
                                pointBorderColor: "rgba(78, 115, 223, 1)",
                                pointHoverRadius: 3,
                                pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
                                pointHoverBorderColor: "rgba(78, 115, 223, 1)",
                                pointHitRadius: 10,
                                pointBorderWidth: 2,
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            layout: {
                                padding: {
                                    left: 10,
                                    right: 40,
                                    top: 25,
                                    bottom: 0
                                }
                            },
                            scales: {
                                xAxes: [{
                                    time: {
                                        unit: 'date'
                                    },
                                    gridLines: {
                                        display: false,
                                        drawBorder: false
                                    },
                                    ticks: {
                                        reverse: true,
                                        maxTicksLimit: 7
                                    }
                                }],
                                yAxes: [{
                                    ticks: {
                                        maxTicksLimit: 5,
                                        padding: 10,
                                    },
                                    gridLines: {
                                        color: "rgb(234, 236, 244)",
                                        zeroLineColor: "rgb(234, 236, 244)",
                                        drawBorder: false,
                                        borderDash: [2],
                                        zeroLineBorderDash: [2]
                                    }
                                }],
                            },
                            legend: {
                                display: false
                            },
                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                titleMarginBottom: 10,
                                titleFontColor: '#6e707e',
                                titleFontSize: 14,
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                intersect: false,
                                mode: 'index',
                                caretPadding: 10,
                            }
                        }
                    }
                );
            }
        },
        mounted() {
            new Promise((resolve, reject) => {
                axios.get('/api/user/' + this.user + '/stats/points')
                    .then((response) => {
                        this.drawChart(response.data)
                    })
            });
        }
    }
</script>

<style scoped>

</style>
