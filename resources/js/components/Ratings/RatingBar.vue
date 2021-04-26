<template>

</template>

<script>
import {createNamespacedHelpers} from 'vuex'

const {mapGetters} = createNamespacedHelpers('rating');

export default {
    props: [
        'points', 'width'
    ],
    mounted() {
        $('[data-toggle="tooltip"]').tooltip();
    }
}
</script>

<style scoped>

</style>
