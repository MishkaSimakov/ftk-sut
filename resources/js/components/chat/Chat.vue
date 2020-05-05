<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-sm-12 mt-2">
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
            <div class="col-md-4 col-sm-12 mt-2">
                <div v-if="loading" class="spinner-border-sm spinner-border mx-1 my-auto" role="status">
                    <span class="sr-only">Загрузка...</span>
                </div>
                <div v-else>
                    <chat-users></chat-users>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    import Bus from '../../bus'
    import moment from 'moment'

    export default {
        props: [
            'id'
        ],
        computed: mapGetters({
            chat: 'currentChat',
            loading: 'loadingChat',
            chats: 'getChats'
        }),
        methods: {
            ...mapActions([
                'getChat',
                'setRead'
            ]),
            moment: moment,
        },
        mounted() {
            this.getChat(this.id);

            Bus.$on('message.edited', ({id, time}) => {
                $('#tooltip_message_' + id).tooltip('dispose').tooltip({
                    title: 'изменено ' + moment(time).locale('ru').calendar().toLowerCase(),
                })
            })
        },
        updated() {
            let messages = document.getElementsByClassName('chat__messages')[0];
            messages.scroll(0, messages.scrollHeight);
        },
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
