<template>
    <form v-on:submit.prevent="handleSubmit">
        <div class="row">
            <div class="col-md-5 mb-2 mb-md-0" data-toggle="tooltip" title="Дата начала выборки">
                <input
                    v-model="periodInput.start"
                    type="month"
                    class="form-control"
                    name="date-start"
                    :max="$moment().format('YYYY-MM')"
                    required
                >
            </div>

            <div class="col-md-2 text-center">
                <i class="fas fa-long-arrow-alt-right fa-2x d-none d-md-inline"></i>
                <i class="fas fa-arrow-down fa-2x d-inline d-md-none"></i>
            </div>

            <div class="col-md-5 mt-2 mt-md-0" data-toggle="tooltip" title="Дата конца выборки">
                <input
                    v-model="periodInput.end"
                    type="month"
                    class="form-control"
                    name="date-end"
                    :min="periodInput.start"
                    :max="$moment().format('YYYY-MM')"
                    required
                >
            </div>
        </div>

        <div class="list-group mt-4">
            <a
                v-for="category in isCategoriesExpanded ? categories : categories.slice(0, 5)"
                href="#"
                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
            >
                {{ category.name }}
            </a>
        </div>

        <div class="text-center">
            <a href="#" v-on:click.prevent="isCategoriesExpanded = !isCategoriesExpanded">показать больше</a>
        </div>

        <button
            type="submit"
            class="float-right mt-3 btn btn-primary"
        >
            Загрузить
        </button>
    </form>
</template>

<script>
import {createNamespacedHelpers} from 'vuex'

const {mapActions, mapGetters} = createNamespacedHelpers('rating');

export default {
    data() {
        return {
            isCategoriesExpanded: false,
            periodInput: {},
        }
    },
    computed: {
        ...mapGetters({
            categories: 'getCategories',
            period: 'getPeriod'
        }),
    },
    methods: {
        ...mapActions(['loadRating', 'setCategoriesFilter']),
        handleSubmit() {
            this.loadRating(this.periodInput)
            // this.setCategoriesFilter(this.categoriesState)

            $('#ratingSettingsModal').modal('hide')
        }
    },
    watch: {
        period() {
            this.periodInput.start = this.period.start
            this.periodInput.end = this.period.end
        }
    }
}
</script>

<style scoped>

</style>
