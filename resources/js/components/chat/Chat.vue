<template>
    <div class="container mt-2">
        <div class="card">
            <div class="card-header">{{ chat.name }}</div>
            <div class="card-body p-0">
                <div v-if="loading" class="d-flex spinner-border my-4 mx-auto" role="status">
                    <span class="sr-only">Загрузка...</span>
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
            this.getChat(this.id)
        }
    }
</script>
