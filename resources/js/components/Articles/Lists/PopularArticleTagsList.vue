<template>
    <div class="card mt-3">
        <div class="card-body py-2">
            <div class="row" v-if="tags.length">
                <a v-for="tag in tags.slice(0, 4)" :key="tag.id" href="#"
                   class="col-md-3 text-center border-right py-2 article-tag">
                    {{ tag.name }}
                </a>
            </div>

            <div v-else class="text-center">
                <div class="spinner-border text-secondary my-1"></div>
            </div>
        </div>
    </div>
</template>

<script>
import {createNamespacedHelpers} from 'vuex'

const {mapGetters, mapActions} = createNamespacedHelpers('articles');

export default {
    computed: {
        ...mapGetters({
            tags: 'getTags'
        })
    },
    methods: {
        ...mapActions([
            'loadTags'
        ])
    },
    mounted() {
        this.loadTags()
    }
}
</script>

<style scoped>
    @media (max-width: 767px) {
        .article-tag {
            border-right: none !important;
        }
    }

    .article-tag {
        text-decoration: none;
    }

    .article-tag:last-child {
        border-right: none !important;
    }
</style>
