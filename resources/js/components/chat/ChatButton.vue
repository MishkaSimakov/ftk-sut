<template>
    <li class="page-navigation__item nav-item">
        <a class="page-navigation__link nav-link" v-bind:href="url">
            Сообщения
            <span v-if="unread_count" class="badge badge-light">{{ unread_count }}</span>
        </a>
    </li>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'

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
        },
    }
</script>

<style scoped>

</style>
