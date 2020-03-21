<template>
    <form action="#" @submit.prevent="">
        <div class="form-group">
            <input type ="text" id="users-add" placeholder="Добавить пользователя" class="form-control">
        </div>
    </form>
</template>

<script>
    import { userautocomplete } from '../../../helpers/autocomplete'
    import {mapActions, mapGetters} from 'vuex'

    export default {
        computed: mapGetters({
            chat: 'currentChat'
        }),
        methods: {
            ...mapActions([
                'addChatUsers'
            ])
        },
        mounted() {
            var users = userautocomplete('#users-add').on('autocomplete:selected', (e, selection) => {
                this.addChatUsers({
                    id: this.chat.id,
                    recipients: [selection].map((recipient) => {
                        return recipient.id
                    })
                })
                users.autocomplete.setVal('')
            })
        }
    }
</script>
