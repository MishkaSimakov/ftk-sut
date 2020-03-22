<template>
    <li class="page-navigation__item nav-item">
        <a class="page-navigation__link nav-link" v-bind:href="url">
            Сообщения
            <span v-if="unread_count" class="badge badge-light">{{ unread_count }}</span>
<!--            <span class="fa fa-comments mx-auto"></span>-->
        </a>
    </li>
</template>

<script>
    import { mapActions, mapGetters } from 'vuex'

    export default {
        props: [
            'url'
        ],
        data() {
            return {
                unread_count: 0,
            }
        },
        computed: mapGetters({
            chats: 'allChats',
        }),
        methods: {
            ...mapActions([
                'getChats',
            ]),
        },
        mounted() {
            this.getChats(1);
        },
        watch: {
            chats(chats) {
                this.unread_count = 0;

                chats.forEach((chat) => {
                    if (chat.isUnread) {
                        this.unread_count++;
                    }
                });
            }
        }
    }
</script>

<style scoped>

</style>
