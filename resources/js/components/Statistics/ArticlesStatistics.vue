<template>
    <div>
        <h2 class="h5 mt-5 mb-1">Статьи</h2>

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="spinner-border text-primary spinner-border-sm my-2" role="status"
                                 v-if="loading"></div>
                            <div class="mb-0 font-weight-bold text-primary h2" v-else>
                                {{ count.articles }}
                            </div>
                            <div class="small text-secondary mb-1">
                                статей
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-3 mt-md-0">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="spinner-border text-info spinner-border-sm my-2" role="status"
                                 v-if="loading"></div>
                            <div class="mb-0 font-weight-bold text-info h2" v-else>
                                {{ count.points }}
                            </div>
                            <div class="small text-info mb-1">
                                оценок на статьях
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mt-3 mt-md-0">
                <div class="card">
                    <div class="card-body p-3">
                        <div class="text-center">
                            <div class="spinner-border text-secondary spinner-border-sm my-2" role="status"
                                 v-if="loading"></div>
                            <div class="mb-0 font-weight-bold text-secondary h2" v-else>
                                {{ count.views }}
                            </div>
                            <div class="small text-secondary mb-1">
                                просмотров на статьях
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="spinner-border spinner-border-sm mx-auto my-3 text-secondary" role="status"
                 v-if="loading"></div>
            <div class="text-center my-3 text-info" v-else-if="!articles.length">
                Нет статей
            </div>
            <template v-else>
                <ul class="list-group list-group-flush">
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

                <a class="text-secondary my-2 mx-auto" :href="route('users.articles', {'user': user})">
                    Все статьи
                </a>
            </template>
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

            articles: [],
            count: {}
        }
    },
    methods: {
        route: route
    },
    created() {
        statisticsApi.loadArticlesStatistics({
            user: this.user
        }).then((response) => {
            this.loading = false

            this.articles = response.data.articles
            this.count = response.data.count
        })
    }
}
</script>

<style scoped>

</style>
