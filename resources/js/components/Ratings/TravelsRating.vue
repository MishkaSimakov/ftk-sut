<template>
    <rating route-name="rating.travels.index" loading-route-name="api.rating.travels.show"  points-column-name="Расстояние, км"></rating>
</template>

<script>
import Rating from "./Rating";

export default {
    components: {Rating}
}
</script>

<style scoped>

</style>
