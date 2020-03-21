<template>
    <div class="container mt-2">
        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="card">
                <div class="card-header">
                    <div class="row">
                        <a href="/chat">
                            <span class="fa fa-arrow-left my-auto ml-2 mr-5"></span>
                        </a>

                        <div v-if="loading" class="spinner-border-sm spinner-border mx-1 my-auto" role="status">
                            <span class="sr-only">Загрузка...</span>
                        </div>
                        <div class="text-primary text-lg" v-else>
                            {{ chat.name }}
                        </div>
                    </div>
                </div>
                <div class="card-body p-1">
                    <div class="chat__messages">
                        <div v-if="loading" class="d-flex spinner-border my-4 mx-auto" role="status">
                            <span class="sr-only">Загрузка...</span>
                        </div>
                        <div id="messages" v-else-if="chat.messages.length">
                            <message v-for="message in chat.messages" :key="message.data" :message="message"></message>
                        </div>
                        <div v-else class="d-flex justify-content-center my-4 mx-auto">
                            <span>Нет сообщений</span>
                        </div>
                    </div>

                    <message-add-form></message-add-form>
                </div>
            </div>
            </div>
            <div class="col-md-4 col-sm-12">
                <div v-if="loading" class="spinner-border-sm spinner-border mx-1 my-auto" role="status">
                    <span class="sr-only">Загрузка...</span>
                </div>
                <div v-else>
                    <chat-name-form v-if="chat.selfOwned"></chat-name-form>
                    <chat-users></chat-users>
                </div>
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
            this.getChat(this.id).then(() => {


                // chat.scroll(0, chat.scrollHeight);
            })
        },
        watch: {
            loading() {
            //    add chat scrolling
            }
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
