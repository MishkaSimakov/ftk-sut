<template>
    <form action="#" class="chat__form">
        <textarea v-bind:class="{ 'is-invalid': error }" @keydown="handleMessageInput" v-model="body" id="body" cols="30" rows="4" class="form-control chat__form-input"></textarea>

<!--        <span v-if="document" class="chat__form-helptext">-->
<!--            <b>Enter</b> чтобы отправить или <b>Shift + Enter</b> для переноса на новую строку-->
<!--        </span>-->
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
            chat: 'currentChat',
            error: 'messageError',
        }),
        methods: {
            ...mapActions([
                'createChatMessage'
            ]),
            handleMessageInput(e) {
                if (e.keyCode === 13 && !e.shiftKey) {
                    e.preventDefault();
                    this.send();
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
                    if (!this.error) {
                        this.body = null;
                    }
                });
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
