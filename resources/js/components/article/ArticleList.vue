<template>
    <div class="articles">
        <find-articles-form v-if="show_search != 'false'"></find-articles-form>

        <div class="mt-2">
            <article-preview v-for="article in articles" :key="article.id" :data="JSON.stringify(article)"></article-preview>

            <div v-observe-visibility="loadArticles" v-if="page <= total" class="my-3 d-flex flex-row justify-content-center">
                <i v-if="random" class="text-info fas fa-robot fa-2x fa-spin"></i>

                <div v-else class="spinner-border text-info" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
            </div>

            <div v-if="!loading && !articles.length">
                <h2 class="text-center">Таких статей нет! 😯</h2>
            </div>
        </div>
    </div>
</template>

<script>
    import Bus from '../../bus'

    export default {
        props: [
            'url',
            'show_search'
        ],
        data() {
            return {
                page: 1,
                total: 1,
                articles: [],

                loading: true,
                random: Math.random() > 0.9
            }
        },
        methods: {
            getParams() {
                let params = {};
                new URLSearchParams(window.location.search).forEach((value, key) => {
                    params[key] = value
                });
                params.page = this.page;

                return {
                    params: params
                }
            },
            getArticles() {
                this.loading = true;

                new Promise((resolve, reject) => {
                    axios.get(this.url, this.getParams()).then((response) => {
                        this.total = response.data.total;
                        this.articles.push(...response.data.data);
                        this.page += 1;

                        this.loading = false;
                    })
                })
            },
            loadArticles(isVisible) {
                if (isVisible) {
                    this.getArticles()
                }
            }
        },
        mounted() {
            Bus.$on('articles.search.apply', (url) => {
                this.articles = [];
                this.page = 1;
            })
        }
    }
</script>
