<template>
    <div>
        <h2 class="h5 mt-5 mb-1">Мероприятия</h2>

        <div class="row mt-3">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="mb-0 font-weight-bold text-primary h2">
                                1234
                            </div>
                            <div class="small text-secondary mb-1">
                                мероприятий, где принял участие
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="mb-0 font-weight-bold text-info h2">
                                12
                            </div>
                            <div class="small text-secondary mb-1">
                                походов, в которые сходил
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="mb-0 font-weight-bold text-secondary h2">
                                12123
                            </div>
                            <div class="small text-secondary mb-1">
                                пройдено км за всё время
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import statisticsApi from "../../api/statistics";

export default {
    props: [
        'user'
    ],
    data() {
        return {
            loading: true,

            data: []
        }
    },
    created() {
        // statisticsApi.loadArticlesStatistics({
        //     user: this.user
        // }).then((response) => {
        //     this.loading = false
        //
        //     this.articles = response.data
        // })
    }
}
</script>

<style scoped>

</style>
