<template>
    <form v-on:submit.prevent="handleSubmit">
        <div class="row">
            <div class="col-md-5 mb-2 mb-md-0" data-toggle="tooltip" title="Дата начала выборки">
                <input
                    v-model="enteredPeriod.start"
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
                    v-model="enteredPeriod.end"
                    type="month"
                    class="form-control"
                    name="date-end"
                    :min="enteredPeriod.start"
                    :max="$moment().format('YYYY-MM')"
                    required
                >
            </div>
        </div>


        <div class="list-group mt-4" ref="categories_list_container">
            <a
                v-for="category in isCategoriesExpanded ? enteredCategories : enteredCategories.slice(0, 5)"
                :key="category.id"
                href="#"
                v-on:click.prevent="toggleCategory(category)"
                class="list-group-item list-group-item-action d-flex justify-content-between align-items-center"
                :class="category.disabled ? '' : 'active'"
            >
                {{ category.name }}
            </a>
        </div>


        <div class="text-center">
            <a href="#" v-on:click.prevent="isCategoriesExpanded = !isCategoriesExpanded">
                {{ isCategoriesExpanded ? 'показать меньше' : 'показать больше' }}
            </a>
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
import smoothHeight from 'vue-smooth-height';

const {mapActions, mapGetters} = createNamespacedHelpers('rating');

export default {
    mixins: [smoothHeight],
    data() {
        return {
            enteredCategories: [], // TODO: сделать, чтобы, если выбраны все категории не была выбрана ни одна.
            isCategoriesExpanded: false,
            enteredPeriod: {
                start: null,
                end: null
            },
        }
    },
    computed: {
        ...mapGetters({
            loadedCategories: 'getCategories',
            loadedPeriod: 'getPeriod'
        }),
    },
    methods: {
        ...mapActions(['loadRating', 'setCategoriesFilter']),
        handleSubmit() {
            this.loadRating(this.enteredPeriod)
            this.setCategoriesFilter(this.enteredCategories)

            $('#ratingSettingsModal').modal('hide')
        },
        toggleCategory(category) {

        }
    },
    watch: {
        loadedPeriod(period) {
            this.enteredPeriod.start = period.start
            this.enteredPeriod.end = period.end
        },
        loadedCategories(categories) {
            this.enteredCategories = categories
        }
    },
    mounted() {
        this.$smoothElement({
            el: this.$refs.categories_list_container,
            hideOverflow: true
        })
    }
}
</script>
