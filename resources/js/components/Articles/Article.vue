<template>
    <div class="card">
        <div class="card-body pb-2">
            <h5 class="card-title">{{ article.title }}</h5>
            <div class="card-text" v-html="article.body"></div>

            <div class="row no-gutters mt-3 text-muted">
                <div class="align-self-center">
                    <a class="text-muted" :href="article.author.url">{{ article.author.name }}</a>
                    <span class="d-none d-sm-inline">• 29 июня 2021</span>
                </div>

                <div class="ml-auto row no-gutters">
                    <span :class="{ 'liked' : article.is_liked }" class="align-self-center mr-sm-2 mr-md-3" style="font-weight: 500; cursor: pointer">
                        <i :class="article.is_liked ? 'fas' : 'far'" class="fa-heart"></i> {{ article.points }}
                    </span>

                    <span class="align-self-center mr-sm-2 d-none d-md-inline" style="font-weight: 500;">
                        <i class="fas fa-eye"></i> {{ article.views }}
                    </span>

                    <div class="dropdown">
                        <button class="d-inline btn rounded-pill" type="button" id="news-more-dropdown-button"
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
export default {
    props: {
        'article': Object,
    }
}
</script>

<style scoped>
    .liked {
        color: #ff3347 !important;
    }
</style>
