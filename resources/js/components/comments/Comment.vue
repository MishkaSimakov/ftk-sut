<template>
    <div class="article__comment">
        <strong class="article__comment-user">{{ comment.user.name }}</strong>
        <span class="article__comment-timestamp">{{ moment(comment.created_at).locale('ru').fromNow() }}</span>

        <p class="article__comment-body">{{ comment.body }}</p>
    </div>
</template>

<script>
    import moment from 'moment'

    export default {
        props: [
            'comment'
        ],
        methods: {
            moment: moment
        }
    }
</script>

<style lang="scss">
    .article {
        &__comment {
            padding: 15px;
            border-bottom: 1px solid #eee;

            &-timestamp {
                margin-left: 10px;
                color: #aaa;
            }

            &-user {
                font-weight: 800;
            }

            &-body {
                margin-bottom: 0;
                white-space: pre-wrap;
            }
        }
    }
</style>
