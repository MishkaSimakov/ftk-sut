<template>
    <div>
        <div v-infinite-scroll="loadArticles" infinite-scroll-disabled="isScrollDisabled" infinite-scroll-distance="20">
            <Article v-for="a in articles" :article="a" :key="a.id" class="mb-3"></Article>

            <div v-if="!isScrollDisabled" class="d-flex justify-content-center">
                <div class="spinner-border text-secondary spinner-border-sm" role="status"></div>
            </div>
        </div>
    </div>
</template>

<script>
import {createNamespacedHelpers} from 'vuex'
import Article from "../Article";

const {mapGetters} = createNamespacedHelpers('articles');

export default {
    components: {Article},
    computed: {
        ...mapGetters({
            articles: 'getArticles',
            isScrollDisabled: 'isScrollDisabled',
        })
    },
    mounted() {
        this.loadArticles()
    },
    methods: {
        loadArticles() {
            this.$store.dispatch('articles/loadArticles')
        }
    }
}
</script>
