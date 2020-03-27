<template>
    <!--        <chat-add-form></chat-add-form>-->

    <div class="mt-4 shadow card">
        <div class="card-header">Комментарии</div>
        <div class="card-body p-0">
            <div v-if="loading" class="d-flex spinner-border my-4 mx-auto" role="status">
                <span class="sr-only">Загрузка...</span>
            </div>

            <div v-else-if="comments.length">
                <comment-add-form v-bind:article_id="article_id" v-if="window.Laravel.user.id"></comment-add-form>
                <comment  v-for="comment in comments" :key="comment.id" :comment="comment"></comment>
            </div>

            <div v-else class="d-flex justify-content-center my-4 mx-auto">
                <span>Нет комментариев</span>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        props: [
            'article_id'
        ],
        data() {
            return {
                window: window,
            }
        },
        computed: mapGetters({
            comments: 'allComments',
            loading: 'loadingComments',
        }),
        methods: {
            ...mapActions([
                'getComments',
            ]),
        },
        mounted() {
            this.getComments(this.article_id)
        }
    }
</script>
