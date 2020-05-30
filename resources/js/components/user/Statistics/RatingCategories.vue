<template>
    <div class="card shadow">
        <div class="card-header">
            <h4 class="font-weight-bold text-primary">Очки за категории</h4>
        </div>

        <div class="card-body">
            <canvas id="categories_stats" width="100" height="250">Где-то здесь должен быть график</canvas>
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
                let chart = new Chart(
                    document.getElementById('categories_stats').getContext('2d'),
                    {
                        type: 'doughnut',
                        data: {
                            labels: Object.keys(data[0]).map(function(key) {
                                return data[0][key]['title']
                            }),
                            datasets: [{
                                label: '# очков за категорию',
                                data: Object.keys(data[1]).map(function(key) {
                                    return data[1][key]
                                }),

                                backgroundColor: Object.keys(data[0]).map(function(key) {
                                    return data[0][key]['color']
                                }),
                                hoverBorderColor: "rgba(234, 236, 244, 1)",
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            tooltips: {
                                backgroundColor: "rgb(255,255,255)",
                                bodyFontColor: "#858796",
                                borderColor: '#dddfeb',
                                borderWidth: 1,
                                xPadding: 15,
                                yPadding: 15,
                                displayColors: false,
                                caretPadding: 10,
                            },
                            legend: {
                                display: false
                            },
                            cutoutPercentage: 80,
                        }
                    }
                );
            }
        },
        mounted() {
            new Promise((resolve, reject) => {
                axios.get('/api/user/' + this.user + '/stats/categories')
                    .then((response) => {
                        this.drawChart(response.data)
                    })
            });
        }
    }
</script>

<style scoped>

</style>
