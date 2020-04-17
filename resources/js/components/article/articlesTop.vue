<template>
    <div class="card mt-2">
        <div class="card-header py-3">
            <h4 class="font-weight-bold text-primary">
                Топ статей
            </h4>
        </div>

        <div class="card-body">
            <ol class="my-2">
                <li v-for="article in articles">
                    <div class="row">
                        <div class="col-md-8 text-truncate">
                            <a v-bind:href="article.url">{{ article.title }}</a>
                        </div>

                        <div class="col-md-4 text-primary">
                            <i class="far fa-heart"></i> {{ article.points }}

                            <i class="far fa-eye ml-2"></i> {{ article.views }}
                        </div>
                    </div>
                </li>
            </ol>
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
                axios.get('/webapi/articles/top/articles').then((response) => {
                    this.articles = response.data;
                })
            })
        }
    }
</script>

<style scoped>

</style>
