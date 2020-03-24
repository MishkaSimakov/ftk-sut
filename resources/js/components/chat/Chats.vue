<template>
    <div class="container mt-2">
        <chat-add-form></chat-add-form>

        <div class="card">
            <div class="card-header">Беседы</div>
            <div class="card-body p-0">
                <div v-if="loading" class="d-flex spinner-border my-4 mx-auto" role="status">
                    <span class="sr-only">Загрузка...</span>
                </div>
                <div v-else-if="chats.length" v-for="chat in chats" :key="chat.id" :chat="chat">
                    <div class="chat border p-2">
                        <div class="chat__header text-lg m-1 row d-flex">
                            <a v-bind:href="'/chat/' + chat.id">
                                {{ trunc(chat.name, 50) }}
                            </a>
                            <div v-if="chat.isUnread" class="badge badge-info my-auto ml-2">new</div>
                            <a v-if="chat.selfOwned" href="#" @click.prevent="deleteChat(chat)" class="ml-auto"><span class="fa fa-trash text-danger fa-sm"></span></a>
                        </div>
                        <ul class="list-inline chat__users text-muted m-1">
                            <li class="list-inline-item"><strong>Участники: </strong></li>
                            <li class="list-inline-item" v-for="user in chat.users">{{ user.name }}</li>
                        </ul>
                    </div>
                </div>
                <div v-else class="d-flex justify-content-center my-4 mx-auto">
                    <span>Нет бесед</span>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    import trunc from '../../helpers/trunc'

    export default {
        computed: mapGetters({
            chats: 'allChats',
            loading: 'loadingChats'
        }),
        methods: {
            ...mapActions([
                'getChat',
                'getChats',
                'deleteChat'
            ]),
            trunc: trunc,
        },
        mounted() {
            this.getChats(1)
        }
    }
</script>
