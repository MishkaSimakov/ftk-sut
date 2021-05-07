<template>
    <div>
        <h2 class="h5 mt-5 mb-1">Статьи</h2>

        <div class="card mt-3">
            <div class="spinner-border spinner-border-sm mx-auto my-3 text-secondary" role="status"
                 v-if="loading"></div>
            <div class="text-center my-3 text-secondary" v-else-if="!articles.length">
                Нет статей
            </div>
            <ul class="list-group list-group-flush" v-else>
                <li class="list-group-item d-flex" v-for="article in articles" :key="article.id">
                    <a :href="article.url" class="text-nowrap text-truncate col-9">{{ article.title }}</a>

                    <div class="ml-auto text-muted row align-items-center flex-nowrap">
                        <div class="mr-2 mr-md-3 article-like-button" style="cursor: default !important;">
                            <i class="far fa-heart"></i>
                            <span> {{ article.points_count }}</span>
                        </div>

                        <span class="mr-2 d-none d-md-inline article-views">
                            <i class="far fa-eye"></i> {{ article.views_count }}
                        </span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
import statisticsApi from "../../api/statistics";

export default {
    props: [
        'user'
    ],
    data() {
        return {
            loading: true,

            articles: []
        }
    },
    created() {
        statisticsApi.loadArticlesStatistics({
            user: this.user
        }).then((response) => {
            this.loading = false

            this.articles = response.data
        })
    }
}
</script>

<style scoped>

</style>
