<template>
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <a href="/chat">
                        <span class="fa fa-arrow-left my-auto ml-2 mr-5"></span>
                    </a>

                    <div v-if="loading" class="spinner-border-sm spinner-border mx-1 my-auto" role="status">
                        <span class="sr-only">Загрузка...</span>
                    </div>
                    <p class="text-primary text-lg" v-else>
                        {{ chat.name }}
                    </p>
                </div>
            </div>
            <div class="card-body p-1">
                <div class="chat__messages">
                    <div v-if="loading" class="d-flex spinner-border my-4 mx-auto" role="status">
                        <span class="sr-only">Загрузка...</span>
                    </div>
                    <div v-else-if="chat.messages.length">
                        <message v-for="message in chat.messages" :key="message.data" :message="message"></message>
                    </div>
                    <div v-else class="my-2 mx-2">
                        Нет сообщений
                    </div>
                </div>

                <message-add-form></message-add-form>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        props: [
            'id'
        ],
        computed: mapGetters({
            chat: 'currentChat',
            loading: 'loadingChat'
        }),
        methods: {
            ...mapActions([
                'getChat'
            ]),
        },
        mounted() {
            this.getChat(this.id)
        }
    }
</script>

<style lang="scss">
    .chat {
        &__messages {
            height: 400px;
            max-height: 400px;
            overflow-y: visible;
            overflow-x: hidden;
        }
    }
</style>
