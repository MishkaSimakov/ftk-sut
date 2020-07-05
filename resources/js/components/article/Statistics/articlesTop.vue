<template>
    <div class="card mt-2">
        <div class="card-body">
            <h5 class="card-title">Лучшие статьи</h5>
            <div v-if="loading" class="text-primary d-flex spinner-border my-4 mx-auto" role="status">
                <span class="sr-only">Загрузка...</span>
            </div>
            <div v-else class="col">
                <div v-for="(article, place) in articles" class="row">
                    <div :class="['col-1', hiding]">
                        {{ parseInt(place) + 1 }}
                    </div>

                    <div :class="['text-truncate', 'col-7', 'col-md-6']">
                        <a :href="article.url">{{ article.title }}</a>
                    </div>

                    <div :class="['col-5']">
                        <div
                            class="progress my-2"
                            :style="{ cursor: 'pointer', height: '40%', width: article.total / max * 100 + '%', position: 'relative' }"
                        >
                            <div
                                class="progress-bar"
                                :style="{ width: article.points / article.total * 100 + '%', backgroundColor: 'coral' }"

                                :data-toggle="article.points > 0 ? 'tooltip' : ''"
                                data-placement="top"
                                :title="'Оценки: ' + article.points"
                            ></div>
                            <div
                                class="progress-bar"
                                :style="{ width: article.views / article.total * 100 + '%', backgroundColor: 'teal' }"

                                :data-toggle="article.views > 0 ? 'tooltip' : ''"
                                data-placement="top"
                                :title="'Просмотры: ' + article.views"
                            ></div>
                        </div>
                    </div>
                </div>
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
                articles: [],
                loading: true,
                max: 0,

                hiding: {
                    'd-none': true,
                    'd-lg-block': true
                },
            }
        },
        mounted() {
            new Promise((resolve, reject) => {
                axios.get(this.url).then((response) => {
                    this.articles = response.data;
                    this.max = this.articles[0].total;
                    this.loading = false;

                    $(function () {
                        $('[data-toggle="tooltip"]').tooltip()
                    })
                })
            })
        }
    }
</script>

<style scoped>

</style>
