<template>
    <div>
        <div v-if="!bestArticles.length" class="d-flex justify-content-center">
            <div class="spinner-border text-secondary spinner-border-sm" role="status"></div>
        </div>
        <div v-else>
            <Article class="mt-3" :article="bestArticles[0]"></Article>

            <div class="row">
                <div class="col-md-6 mt-3">
                    <Article class="mt-3" :article="bestArticles[1]"></Article>
                </div>

                <div class="col-md-6 mt-3">
                    <Article class="mt-3" :article="bestArticles[2]"></Article>
                </div>
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
            bestArticles: 'getBestArticles',
        })
    }
}
</script>
