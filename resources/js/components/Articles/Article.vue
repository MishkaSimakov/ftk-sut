<template>
    <div class="card h-100">
        <div class="card-body pb-2 d-flex flex-column">
            <h5 class="card-title">{{ article.title }}</h5>
            <div class="card-text" v-html="article.body"></div>

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

                    <div class="dropdown">
                        <button class="d-inline btn rounded-pill text-muted" type="button" id="news-more-dropdown-button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-h fa-sm"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="news-more-dropdown-button">
                            <a class="dropdown-item" href="#">Редактировать</a>

                            <a class="dropdown-item text-danger" href="#">
                                Удалить
                            </a>
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
    }
}
</script>
