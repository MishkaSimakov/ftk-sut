<template>
    <div>
<!--        <news-filter></news-filter>-->

        <div v-infinite-scroll="loadNews" infinite-scroll-disabled="isScrollDisabled" infinite-scroll-distance="20">
            <News v-for="n in news" :news="n" :key="n.id"></News>

            <div v-if="!isScrollDisabled" class="d-flex justify-content-center">
                <div class="spinner-border text-secondary"></div>
            </div>
        </div>
    </div>
</template>

<script>
import { createNamespacedHelpers } from 'vuex'
const { mapGetters } = createNamespacedHelpers('news');

import News from "./News";
import NewsFilter from "./NewsFilter";

export default {
    components: {NewsFilter, News},
    computed: {
        ...mapGetters({
            news: 'getNews',
            isScrollDisabled: 'isScrollDisabled',
            sortType: 'getSortType'
        })
    },
    methods: {
        loadNews() {
            this.$store.dispatch('news/loadNews', {sortType: this.sortType})
        }
    }
}
</script>

<style scoped>

</style>
