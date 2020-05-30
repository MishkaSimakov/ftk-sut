<template>
    <div>
        <div v-if="chat.selfOwned">
            <chat-user-add-form></chat-user-add-form>
        </div>

        <ul class="list-unstyled px-2 mb-0">
            <li v-for="user in chat.users">
                <a v-bind:href="user.url" v-bind:title="user.name">{{ user.name }}</a>

                <span v-if="chat.ownerId === user.id">
                    <span class="fa fa-star text-info" title="Создатель группы"></span>
                </span>

                <span v-else-if="chat.selfOwned">
                    <a title="Исключить из чата" href="#" @click.prevent="removeUser(user)">
                        <span class="fa fa-user-times"></span>
                    </a>
                </span>
            </li>
        </ul>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {
        computed: mapGetters({
            chat: 'currentChat'
        }),
        methods: {
            ...mapActions([
                'removeChatUser'
            ]),
            removeUser(user) {
                this.removeChatUser({
                    id: this.chat.id,
                    user: user.id
                })
            }
        }
    }
</script>
