<template>
    <div class="chat__message" :class="{ 'chat__message--own' : message.selfOwned }">
        <strong class="chat__message-user">{{ message.user.name }}</strong>
        <span class="chat__message-timestamp">{{ message.timeForHuman }}</span>

        <p class="chat__message-body">{{ message.body }}</p>
    </div>
</template>

<script>
    export default {
        props: [
            'message'
        ]
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
        }
    }
</style>
