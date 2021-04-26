<template>
    <div>
        <div class="my-2 card w-100">
            <div class="card-body py-2" ref="rating_container">
                <div v-if="isLoading" class="text-secondary d-flex spinner-border my-4 mx-auto" role="status"></div>
                <div v-else class="col">
                    <div class="row">
                        <div class="my-auto font-weight-bolder" :class="columnSizes.place">
                            №
                        </div>
                        <div class="my-auto font-weight-bolder" :class="columnSizes.name">
                            Фамилия, имя
                        </div>

                        <div class="my-auto font-weight-bolder" :class="columnSizes.points">
                            Очки
                        </div>

                        <button class="btn text-primary text-right font-weight-bold" :class="columnSizes.categories"
                                data-toggle="modal"
                                data-target="#ratingSettingsModal">
                            <span class="d-none d-md-inline">Настроить</span> <i class="fas fa-cog ml-2"></i>
                        </button>
                    </div>
                    <div v-if="rating.length">
                        <div v-for="(points, place) in rating" :key="points.user.id" class="row">
                            <div :class="columnSizes.place">
                                {{ place + 1 }}
                            </div>
                            <div class="text-truncate" :class="columnSizes.name">
                                <a class="text-decoration-none" :href="points.user.url">{{ points.user.name }}</a>
                            </div>
                            <div class="text-truncate" :class="columnSizes.points">
                                {{ points.total }}
                            </div>
                            <div :class="columnSizes.categories">
                                <div
                                    class="progress my-2"
                                    :style="{
                                        width: `${points.width}%`,
                                        cursor: 'pointer',
                                        height: '40%',
                                        position: 'relative'
                                    }"
                                >
                                    <div
                                        v-for="point in points.points"
                                        v-if="!point.category.disabled"

                                        class="progress-bar"
                                        :style="{ width: `${point.width}%`, backgroundColor: point.category.color }"

                                        data-toggle="tooltip"
                                        data-placement="top"
                                        :title="point.category.name + ': ' + point.amount"
                                    ></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div v-else class="my-3 text-center h6 text-info">
                        <span class="mx-3">Нет данных за этот период</span>
                    </div>
                </div>
            </div>
        </div>


        <!--        Форма настроек рейтинга -->
        <div class="modal fade" id="ratingSettingsModal" tabindex="-1" role="dialog"
             aria-labelledby="ratingSettingsModalTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ratingSettingsModalTitle">Настройки рейтинга</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <rating-settings-form></rating-settings-form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import RatingSettingsForm from "./../Ratings/Settings/SettingsForm";
import smoothHeight from "vue-smooth-height";
import {createNamespacedHelpers} from 'vuex'

const {mapActions, mapGetters} = createNamespacedHelpers('rating');

export default {
    mixins: [smoothHeight],
    components: {RatingSettingsForm},
    data() {
        return {
            columnSizes: {
                place: 'col-1 d-none d-lg-inline',
                name: 'col-6 col-md-4 col-lg-3',
                points: 'col-2 d-none d-lg-inline',
                categories: 'col-6 col-md-8 col-lg-6'
            }
        }
    },
    methods: {
        ...mapActions({
            loadRating: 'loadRating'
        })
    },
    computed: {
        ...mapGetters({
            rating: 'getSortedRating',
            categories: 'getCategories',
            isLoading: 'isLoading'
        })
    },
    created() {
        this.loadRating();
    },
    mounted() {
        this.$smoothElement({
            el: this.$refs.rating_container,
            hideOverflow: true,
        })
    },
    updated() {
        if (this.rating.length && !this.isLoading) {
            $('[data-toggle="tooltip"]').tooltip('dispose').tooltip();
        }
    }
}
</script>
