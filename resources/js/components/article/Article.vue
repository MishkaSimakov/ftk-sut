<template>
    <div class="card shadow my-2">
        <div class="card-header d-flex flex-grow-1 px-1">
            <h4 class="col-md-8 text-truncate d-block font-weight-bold text-primary">
                <a :title="article.title" :href="article.url">
                    {{ article.title }}
                </a>
            </h4>

            <a class="d-none d-md-block ml-auto mr-2 text-muted" :href="article.user.url">
                {{ article.user.name }}
            </a>
        </div>

        <div class="card-body article__body">
            <div v-html="article.body" id="article_text" class="article__body-text"></div>

            <a id="article_read_more" v-if="articleLengthOverflow" class="btn btn-outline-primary mt-2" title="Читать полностью" :href="article.url">
                Читать полностью <i class="fa fa-arrow-right ml-1"></i>
            </a>

            <div v-if="article.tags.length">
                <hr>

                <span class="mb-1">
                    <a style="cursor: pointer" v-for="tag in article.tags" v-on:click="searchTag(tag)">
                        <span class="text-muted mr-2">{{ tag.name }}</span>
                    </a>
                </span>
            </div>
        </div>

        <div class="card-footer p-1">
            <div class="h3 my-auto mx-2 d-flex flex-grow-1">
                <article-actions :url="'api/article/' + article.id + '/points'" :auth="auth" :data="JSON.stringify(article)"></article-actions>

                <span class="h5 my-auto text-muted ml-auto d-none d-sm-inline">
                    {{ article.date }}
                </span>
            </div>
        </div>
    </div>
</template>

<script>
    import Bus from '../../bus'

    export default {
        props: [
            'data',
        ],
        methods: {
            searchTag(tag) {
                let url = new URL(window.location.href);

                url.searchParams.set('tag', tag.id);

                history.pushState({}, null, url.href);
                Bus.$emit('articles.search.apply', url);
            }
        },
        data() {
            return {
                article: JSON.parse(this.data),
                auth: window.Laravel.user.id !== null,
                articleLengthOverflow: false
            }
        },
        mounted() {
            $('img').each(function () {
                $(this).addClass('mw-100 h-auto');
            });

            $('blockquote').each(function () {
                $(this).addClass('pl-3 my-1 blockquote');
                $(this).attr('style', 'border-left: 3px solid lightgray;')
            });

            this.articleLengthOverflow = $('.article__body').children('#article_text').height() >= 500
        }
    }
</script>

<style scoped>

</style>
