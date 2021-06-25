<template>
    <rating route-name="rating.index" loading-route-name="api.rating.show" points-column-title="Очки"></rating>
</template>

<script>
import Rating from "./Rating";

export default {
    components: {Rating},
}
</script>
