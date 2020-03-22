<template>
    <div class="card">
        <div class="card-header">
            Информация
        </div>
        <div class="card-body">
            <div v-if="chat.selfOwned">
                <chat-name-form></chat-name-form>

                <hr>

                <chat-user-add-form></chat-user-add-form>
            </div>

            <ul class="mb-0">
                <li v-for="user in chat.users">
                    {{ user.name }}

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
