<template>
    <div>
        <news-filter></news-filter>

        <div v-infinite-scroll="loadNews" infinite-scroll-disabled="isScrollDisabled" infinite-scroll-distance="20">
            <News v-for="n in news" :news="n" :key="n.id"></News>

            <div v-if="!isScrollDisabled" class="d-flex justify-content-center">
                <div class="spinner-border text-secondary">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {mapGetters} from 'vuex';
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
            this.$store.dispatch('loadNews', {sortType: this.sortType})
        }
    }
}
</script>

<style scoped>

</style>
