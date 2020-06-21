<template>
    <div class="articles">
        <find-articles-form></find-articles-form>

        <div class="mt-2">
            <article-preview v-for="article in articles" :key="article.id" :data="JSON.stringify(article)"></article-preview>

            <div v-if="page < lastPage" class="spinner">
                <div class="bounce1"></div>
                <div class="bounce2"></div>
                <div class="bounce3"></div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'url'
        ],
        data() {
            return {
                page: 0,
                lastPage: 0,
                articles: [],
                loading: false,

                sort: new URLSearchParams(window.location.search).get('sort'),
                tag: new URLSearchParams(window.location.search).get('tag'),
                search: new URLSearchParams(window.location.search).get('search')
            }
        },
        methods: {
            getArticles() {
                new Promise((resolve, reject) => {
                    axios.get(this.url, {
                        params: {
                            page: this.page
                        }
                    }).then((response) => {
                        this.lastPage = response.data.last_page;
                        this.articles.push(...response.data.data);
                    })
                })
            },
            loadArticles(isVisible) {
                if (isVisible) {
                    this.page++;
                    this.getArticles()
                }
            }
        },
        mounted() {
            this.getArticles();
            this.page++;
        }
    }
</script>

<style lang="scss">
    .articles {
        .spinner {
            margin: 100px auto 0;
            width: 70px;
            text-align: center;
        }

        .spinner > div {
            width: 18px;
            height: 18px;
            background-color: #333;

            border-radius: 100%;
            display: inline-block;
            -webkit-animation: sk-bouncedelay 1.4s infinite ease-in-out both;
            animation: sk-bouncedelay 1.4s infinite ease-in-out both;
        }

        .spinner .bounce1 {
            -webkit-animation-delay: -0.32s;
            animation-delay: -0.32s;
        }

        .spinner .bounce2 {
            -webkit-animation-delay: -0.16s;
            animation-delay: -0.16s;
        }

        @-webkit-keyframes sk-bouncedelay {
            0%, 80%, 100% {
                -webkit-transform: scale(0)
            }
            40% {
                -webkit-transform: scale(1.0)
            }
        }

        @keyframes sk-bouncedelay {
            0%, 80%, 100% {
                -webkit-transform: scale(0);
                transform: scale(0);
            }
            40% {
                -webkit-transform: scale(1.0);
                transform: scale(1.0);
            }
        }
    }
</style>
