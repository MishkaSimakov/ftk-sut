<template>
    <div
        class="progress my-2"
        :style="{ width: `${width}%`, cursor: 'pointer', height: '40%', position: 'relative'}"
    >
        <div
            v-for="point in sortedPoints"
            v-if="!point.disabled"

            class="progress-bar"
            :style="{ width: `${point.width}%`, backgroundColor: point.category.color }"

            data-toggle="tooltip"
            data-placement="top"
            :title="point.category.name + ': ' + point.amount"
        ></div>
    </div>
</template>

<script>
import { mapGetters } from 'vuex'


export default {
    props: [
        'points', 'width'
    ],
    computed: {
        ...mapGetters({
            getCategory: 'rating/getCategory'
        }),
        sortedPoints() {
            return this.points
                .map((p) => {
                    p.category = this.getCategory(p.category)
                    return p
                })
                .sort((a, b) => a.category.order - b.category.order)
        }
    },
    mounted() {
        $('[data-toggle="tooltip"]').tooltip()
    },
}
</script>

<style scoped>

</style>
