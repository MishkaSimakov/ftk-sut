<template>
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="text-center">
                        <div class="mb-0 font-weight-bold text-primary h2">10000</div>
                        <div class="small text-secondary mb-1">
                            очков за всё время
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body p-3">
                    <div class="text-center">
                        <div class="mb-0 font-weight-bold text-secondary h2">500</div>
                        <div class="small text-secondary mb-1">
                            очков за последний месяц
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-8">
            <div class="card h-100">
                <div class="card-body">
                    <bar-chart/>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import statisticsApi from '../../api/statistics'
import BarChart from "./Charts/BarChart";

export default {
    components: {BarChart},
    props: [
        'user'
    ],
    data() {
        return {
            loading: true,
        }
    },
    created () {
        statisticsApi.loadRatingPointsStatistics({
            user: this.user
        }).then((response) => {
            console.log(response)

            this.loading = false;
        })
    }
}
</script>

<style scoped>

</style>
