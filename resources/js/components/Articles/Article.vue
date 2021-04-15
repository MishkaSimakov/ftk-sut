<template>
    <div class="card h-100">
        <div class="card-body pb-2 d-flex flex-column">
            <div style="transform: translate(0)">
                <h5 class="card-title">
                    <a :href="article.url" class="stretched-link article-title-link">{{ article.title }}</a>
                </h5>
                <div class="card-text" v-html="article.body"></div>
            </div>

            <div class="row no-gutters mt-auto text-muted">
                <div class="align-self-center">
                    <a class="text-muted" :href="article.author.url">{{ article.author.name }}</a>
                    <span class="d-none d-sm-inline">• {{ $moment(article.date).format('ll') }}</span>
                </div>

                <div class="ml-auto row no-gutters">
                    <article-like :article="article"></article-like>

                    <span class="align-self-center mr-sm-2 d-none d-md-inline" style="font-weight: 500;">
                        <i class="far fa-eye"></i> {{ article.views }}
                    </span>

                    <div class="dropdown" v-if="isAdmin">
                        <button class="d-inline btn rounded-pill text-muted" type="button"
                                id="article-more-dropdown-button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-h fa-sm"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="article-more-dropdown-button">
                            <a class="dropdown-item" :href="route('article.edit', { article: article.id })">Редактировать</a>
                            <a class="dropdown-item text-danger" href="#" v-on:click.prevent="deleteArticle">
                                Удалить
                            </a>

                            <form :id="destroyFormId" class="d-none" method="POST"
                                  :action="route('article.destroy', { article: article.id })">
                                <input type="hidden" name="_token" :value="csrf">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import ArticleLike from "./Parts/ArticleLike";
export default {
    components: {ArticleLike},
    props: {
        article: Object,
    },
    data() {
        return {
            destroyFormId: `destroy_form_${this.article.id}`,
            csrf: window.Laravel.csrfToken,
            isAdmin: window.Laravel.user && window.Laravel.user.is_admin
        }
    },
    methods: {
        route: route,
        deleteArticle() {
            $(`#${this.destroyFormId}`).submit()
        }
    }
}
</script>

<style scoped lang="scss">
    .article-title-link {
        color: inherit !important;
    }
</style>
