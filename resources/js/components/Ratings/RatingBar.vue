<template>
    <div
        class="progress my-2"
        :style="{ width: `${width}%`, cursor: 'pointer', height: '40%', position: 'relative'}"
    >
        <div
            v-for="point in sortedPoints"
            v-if="!point.category.disabled"

            class="progress-bar"
            :style="{ width: `${point.width}%`, backgroundColor: point.category.color }"

            data-toggle="tooltip"
            data-placement="top"
            :title="point.category.name + ': ' + point.amount"
        ></div>
    </div>
</template>

<script>
import {createNamespacedHelpers} from 'vuex'

const {mapGetters} = createNamespacedHelpers('rating');

export default {
    props: [
        'points', 'width'
    ],
    computed: {
        sortedPoints() {
            return this.points
        }
    },
    mounted() {
        $('[data-toggle="tooltip"]').tooltip();
    }
}
</script>

<style scoped>

</style>
