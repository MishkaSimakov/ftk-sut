<template>
    <div class="card mt-2">
        <div class="card-header py-3">
            <h4 class="font-weight-bold text-primary">
                Недавние комментарии
            </h4>
        </div>

        <div class="card-body">
            <ol v-if="articles.length" class="my-2">
                <li v-for="article in articles">
                    <div class="row">
                        <div class="col-md-10 text-truncate">
                            <a v-bind:href="article.url">{{ article.title }}</a>
                        </div>

                        <div class="col-md-2 ml-auto px-0 text-primary">
                            +{{ article.comments }} <i class="far fa-comment"></i>
                        </div>
                    </div>
                </li>
            </ol>
            <div v-else>
                <p class="text-muted text-center">В последнее время не было комментариев</p>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                articles: []
            }
        },
        mounted() {
            new Promise((resolve, reject) => {
                let tag = new URLSearchParams(window.location.search).get('tag');

                axios.get('/webapi/articles/top/comments' + (tag ? `?tag=${tag}` : '')).then((response) => {
                    this.articles = response.data;
                })
            })
        }
    }
</script>
