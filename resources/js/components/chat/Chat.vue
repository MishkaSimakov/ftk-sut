<template>
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">
                <div v-if="loading" class="spinner-border-sm spinner-border mx-1 my-auto" role="status">
                    <span class="sr-only">Загрузка...</span>
                </div>
                <p v-else>
                    {{ chat.name }}
                </p>
            </div>
            <div class="card-body p-1">
                <div v-if="loading" class="d-flex spinner-border my-4 mx-auto" role="status">
                    <span class="sr-only">Загрузка...</span>
                </div>
                <div v-else-if="chat.messages.length">
                    <message v-for="message in chat.messages" :key="message.data" :message="message"></message>
                </div>
                <div v-else>
                    Нет сообщений
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
