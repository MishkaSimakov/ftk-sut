<template>
    <span v-on:click="togglePoint({ article_id: article.id })" :class="{ 'liked' : article.is_liked }" class="align-self-center mr-sm-2 mr-md-3"
          style="font-weight: 500; cursor: pointer">
        <i :class="article.is_liked ? 'fas' : 'far'" class="fa-heart"></i> {{ article.points }}
    </span>
</template>

<script>
import {createNamespacedHelpers} from 'vuex'

const {mapActions} = createNamespacedHelpers('articles');

export default {
    props: {
        article: Object,
    },
    methods: {
        ...mapActions(['togglePoint'])
    }
}
</script>

<style scoped>
.liked {
    color: #ff3347 !important;
}
</style>
