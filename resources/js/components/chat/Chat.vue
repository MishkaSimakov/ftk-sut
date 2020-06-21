<template>
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <a href="/chat" class="ml-1">
                        <i class="fas fa-arrow-left"></i>
                    </a>

                    <div class="text-truncate col-8 text-center text-primary h5 m-auto">
                        <span data-toggle="tooltip" :data-title="chat.name" v-if="!loading">
                            {{ chat.name }}
                        </span>
                    </div>

                    <div v-on:click="openSettings" style="cursor: pointer" class="my-auto text-primary mr-1">
                        <i class="fas fa-cog"></i>
                    </div>

                    <chat-settings ref="settings" :chat="chat" v-if="!loading"></chat-settings>
                </div>
            </div>
            <div class="card-body p-1">
                <div class="chat__messages">
                    <div v-if="loading" class="d-flex spinner-border my-4 mx-auto" role="status">
                        <span class="sr-only">Загрузка...</span>
                    </div>
                    <div id="messages" v-else-if="chat.messages.length">
                            <div
                                v-if="!(loading || page <= 0) || loadingPage"
                                v-observe-visibility="loadPage"
                                class="d-flex flex-grow-1 my-5 spinner-border mx-auto text-info"
                                role="status"
                            ></div>

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
            loadingPage: 'loadingPage',
            chats: 'getChats',
            page: 'getCurrentPage',
        }),
        methods: {
            ...mapActions([
                'getChat',
                'setRead',
                'loadChatPage',
                'scrolled'
            ]),
            moment: moment,
            openSettings() {
                $(this.$refs.settings.$el).modal('show')
            },
            loadPage(isVisible) {
                if (isVisible && !this.loadingPage) {
                    this.loadChatPage(this.id);
                }
            },
            scrollToMessage(id) {
                let message = document.getElementById('message_' + id);
                let offset = -$('.chat__messages').innerHeight() + message.clientHeight;

                let options = {
                    container: '.chat__messages',
                    easing: 'ease-in',
                    offset: offset,
                    force: true,
                    cancelable: false,
                    onDone: () => {
                        this.scrolled();
                    },
                    x: false,
                    y: true
                };

                this.$scrollTo(message, 500, options)
            },
        },
        mounted() {
            this.getChat(this.id);

            Bus.$on('message.edited', ({id, time}) => {
                $('#tooltip_message_' + id).tooltip('dispose').tooltip({
                    title: 'изменено ' + moment(time).locale('ru').calendar().toLowerCase(),
                })
            }).$on('chat.scroll', (id) => {
                this.$nextTick(() => {
                    this.scrollToMessage(id);
                });
            });
        },
        updated() {
            $(function () {
                $('[data-toggle="tooltip"]').tooltip()
            });
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
