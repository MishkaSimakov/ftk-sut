<template>
    <div v-if="loading" id="loader" class="d-flex mt-5 justify-content-center">
        <div class="text-gray-600 spinner-border text-lg" role="status">
            <span class="sr-only"></span>
        </div>

        <span class="text-gray-600 ml-3 my-auto h3">
            <strong>Загрузка...</strong><br>
        </span>
    </div>

    <div class="rating" v-else-if="rating.length">
        <div id="rating_chart"></div>

        <div class="d-none" id="names"></div>
    </div>

    <div v-else>Ничего нет!</div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        props: [
            'id'
        ],
        computed: mapGetters({
            rating: 'rating',
            loading: 'loading'
        }),
        methods: {
            ...mapActions([
                'getRating',
                'drawChart',
                'loadChart'
            ]),
        },
        mounted() {
            this.getRating(this.id);

            this.loadChart()
        },
        watch: {
            rating() {
                console.log($('#rating_chart'))

                this.drawChart($('#rating_chart'))
            }
        }
    }
</script>

<style scoped>

</style>
