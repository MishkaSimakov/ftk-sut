<template>
    <rating route-name="rating.articles.index" loading-route-name="api.rating.articles.show"  points-column-name="Очки"></rating>
</template>

<script>
import Rating from "./Rating";

export default {
    components: {Rating}
}
</script>

<style scoped>

</style>
