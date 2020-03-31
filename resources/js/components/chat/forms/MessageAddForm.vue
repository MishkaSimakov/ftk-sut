<template>
    <div v-if="touch" class="input-group p-2 border-top">
        <input type="text" placeholder="Напишите сообщение..." v-bind:class="{ 'is-invalid': error }" @keydown="handleMessageInput" v-model="body" class="rounded form-control">

        <div class="input-group-append">
            <a class="btn btn-outline-primary" href="#" @click.prevent="send">
                <span class="fa fa-angle-right"></span>
            </a>
        </div>
    </div>

    <form v-else action="#" class="chat__form">
        <div class="form-group has-feedback">
            <div class="col p-0">
                <textarea v-bind:class="{ 'is-invalid': error }" @keydown="handleMessageInput" v-model="body" cols="30" rows="4" class="form-control chat__form-input"></textarea>

<!--                <a href="#" @click.prevent="addImage" class="text-muted chat__form-image">-->
<!--                    <i class="fa fa-camera"></i>-->
<!--                </a>-->
            </div>
        </div>

        <span class="chat__form-helptext">
            <b>Enter</b> чтобы отправить или <b>Shift + Enter</b> для переноса на новую строку
        </span>
    </form>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {
        data() {
            return {
                body: null,
                bodyBackedUp: null,
                touch: false
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
            isTouchDevice() {
                return true === ("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch);
            },
            handleMessageInput(e) {
                this.bodyBackedUp = this.body;

                if (e.keyCode === 13 && !e.shiftKey) {
                    e.preventDefault();
                    this.send();
                }
            },
            // addImage() {
            //     let input = document.createElement('input');
            //     input.type = 'file';
            //
            //     input.onchange = e => {
            //         var file = e.target.files[0];
            //
            //         var reader = new FileReader();
            //         reader.readAsText(file,'UTF-8');
            //
            //         reader.onload = readerEvent => {
            //             var content = readerEvent.target.result;
            //             console.log( content );
            //         }
            //     };
            //
            //     input.click();
            // },
            send() {
                if (!this.body || this.body.trim() === '') {
                    return
                }

                this.body = null;

                this.createChatMessage({
                    id: this.chat.id,
                    body: this.bodyBackedUp
                }).then(() => {
                    if (this.error) {
                        this.body = this.bodyBackedUp;
                    }
                });
            }
        },
        mounted() {
            this.touch = this.isTouchDevice()

            console.log(this.touch)
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

            &-image {
                position: absolute;
                top: .5rem;
                right: 1rem;
                z-index: 2;
                display: block;
                text-align: center;
            }
        }
    }
</style>
