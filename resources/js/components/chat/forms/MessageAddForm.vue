<template>
    <form action="#" class="chat__form">
        <textarea @keydown="handleMessageInput" v-model="body" id="body" cols="30" rows="4" class="chat__form-input"></textarea>

        <span class="chat__form-helptext">
            <b>Return</b> чтобы отправить или <b>Shift + Return</b> для переноса на новую строку
        </span>
    </form>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {
        data() {
            return {
                body: null,
            }
        },
        computed: mapGetters({
            chat: 'currentChat'
        }),
        methods: {
            ...mapActions([
                'createChatMessage'
            ]),
            handleMessageInput(e) {
                if (e.keyCode === 13 && !e.shiftKey) {
                    e.preventDefault()
                    this.send()
                }
            },
            send() {
                if (!this.body || this.body.trim() === '') {
                    return
                }

                this.createChatMessage({
                    id: this.chat.id,
                    body: this.body
                }).then(() => {
                    this.body = null;
                })
            }
        }
    }
</script>

<style lang="scss">
    .chat {
        background-color: #fff;
        border: 1px solid #d3e0e9;
        border-radius: 3px;

        &__form {
            border-top: 1px solid #d3e0e9;
            padding: 10px;

            &-input {
                width: 100%;
                border: 1px solid #d3e0e9;
                padding: 5px 10px;
                outline: none;
            }

            &-helptext {
                color: #aaa;
            }
        }
    }
</style>
