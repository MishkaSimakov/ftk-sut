<template>
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">Беседы</div>
            <div class="card-body p-0">
                <div v-if="loading" class="d-flex spinner-border my-4 mx-auto" role="status">
                    <span class="sr-only">Загрузка...</span>
                </div>
                <div v-else-if="chats.length" v-for="chat in chats" :key="chat.id" :chat="chat">
                    <a v-bind:href="chat.id">
                        <div class="chat border p-2">
                            <div class="chat__header">
                                {{ chat.name }}
                            </div>
                            <ul class="list-inline chat__users">
                                <li class="list-inline-item" v-for="user in chat.users">{{ user.name }}</li>
                            </ul>
                        </div>
                    </a>
                </div>
                <div v-else>Нет бесед</div>
            </div>
        </div>
    </div>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        computed: mapGetters({
            chats: 'allChats',
            loading: 'loadingChats'
        }),
        methods: {
            ...mapActions([
                'getChat',
                'getChats',
            ]),
        },
        mounted() {
            this.getChats(1)
        }
    }
</script>
