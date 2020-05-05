<template>
    <div class="article__comment">
        <strong class="article__comment-user">{{ comment.user.name }}</strong>
        <span class="article__comment-timestamp">{{ moment(comment.created_at).locale('ru').fromNow() }}</span>

        <div v-if="comment.selfOwned && moment(comment.created_at).isAfter(moment().subtract(2, 'hours'))" class="float-right">
            <div class="article__comment-edit">
                <a href="#" @click.prevent="edit" title="Редактировать"><i class="small fa fa-pen"></i></a>
            </div>
        </div>

        <p class="article__comment-body">{{ comment.body }}</p>
    </div>
</template>

<script>
    import moment from 'moment'
    import Bus from '../../bus'

    export default {
        props: [
            'comment'
        ],
        methods: {
            moment: moment,
            edit() {
                Bus.$emit('comment.edit', this.comment)
            }
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

            &-edit {
                opacity: 0;
                transition: opacity 100ms ease 100ms;
            }
        }

        &__comment:hover {
            .article__comment-edit {
                opacity: 1;
            }
        }
    }
</style>
