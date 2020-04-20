<template>
    <div class="chat__message" :class="{ 'chat__message--own' : message.selfOwned }">
        <strong class="chat__message-user">{{ message.user.name }}</strong>
        <span class="chat__message-timestamp">{{ moment(message.created_at).locale('ru').fromNow() }}</span>

        <div v-if="message.selfOwned" class="chat__message-edit float-right">
            <a href="#" @click.prevent="edit" title="Редактировать"><i class="small fa fa-pen"></i></a>
        </div>

        <p class="chat__message-body"><span v-html="link(message.body)"></span><span v-if="message.is_edited" class="text-muted ml-2" v-bind:id="'tooltip_message_' + message.id">(ред.)</span></p>

        <div class="row" v-if="message.images && message.images.length">
            <img v-for="image in message.images" alt="Картинка" class="chat__message-image card-img m-2" v-bind:src="image" data-lity>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'
    import Bus from '../../bus'
    import link from '../../helpers/link'

    export default {
        props: [
            'message'
        ],
        methods: {
            moment: moment,
            link: link,
            edit() {
                Bus.$emit('message.edit', this.message)
            }
        },
        mounted() {
            if (this.message.is_edited) {
                $('#tooltip_message_' + this.message.id).tooltip({
                    title: 'изменено ' + moment(this.message.updated_at).locale('ru').calendar().toLowerCase(),
                })
            }
        }
    }
</script>

<style lang="scss">
    .chat {
        &__message {
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

            &--own {
                background-color: #f0f0f0;
            }

            &-image {
                max-height: 10rem;
                max-width: 10rem;
                cursor: pointer;
            }

            &-edit {
                opacity: 0;
                transition: opacity 100ms ease 100ms;
            }
        }

        &__message:hover {
            .chat__message-edit {
                opacity: 1;
            }
        }
    }
</style>
