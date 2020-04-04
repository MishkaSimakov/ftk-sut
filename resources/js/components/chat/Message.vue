<template>
    <div class="chat__message" :class="{ 'chat__message--own' : message.selfOwned }">
        <strong class="chat__message-user">{{ message.user.name }}</strong>
        <span class="chat__message-timestamp">{{ moment(message.created_at).locale('ru').fromNow() }}</span>

        <p class="chat__message-body">{{ message.body }}</p>

        <div class="row" v-if="message.images && message.images.length">
            <img v-for="image in message.images" alt="Картинка" class="chat__message-image card-img m-2" v-bind:src="image" data-lity>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'

    export default {
        props: [
            'message'
        ],
        methods: {
            moment: moment
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
        }
    }
</style>
