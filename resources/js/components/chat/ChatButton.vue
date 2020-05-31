<template>
    <li>
        <a v-bind:href="url"><i class="fas fa-comments mr-2"></i>Сообщения</a>

        <span v-if="unread_count" class="ml-2 badge badge-light my-auto">{{ unread_count }}</span>
    </li>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'
    import Bus from '../../bus'

    export default {
        props: [
            'url'
        ],
        computed: mapGetters({
            unread_count: 'unreadCount',
        }),
        methods: {
            ...mapActions([
                'getChats',
            ]),
        },
        mounted() {
            this.getChats(1);

            Bus.$on('chat.read', (id) => {
                this.getChats(1)
            })
        },
    }
</script>

<style scoped>

</style>
