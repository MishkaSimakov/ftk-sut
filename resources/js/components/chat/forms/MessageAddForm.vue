<template>
    <form id="chat_form" action="#" class="chat__form" enctype="multipart/form-data">
        <div v-if="touch" class="input-group p-2 border-top">
            <input type="text" placeholder="Напишите сообщение..." v-bind:class="{ 'is-invalid': error }" @keydown="handleMessageInput" v-model="body" class="rounded form-control">

            <div class="input-group-append">
                <a class="btn btn-outline-primary" href="#" @click.prevent="send">
                    <span class="fa fa-angle-right"></span>
                </a>
            </div>
        </div>

        <div v-else>
            <div class="chat__form-helptext mb-2" v-if="edited_message">
                Редактирование сообщения

                <a href="#" @click.prevent="cancel_edit" class="text-gray-500 float-right">
                    <i class="fas fa-times"></i>
                </a>
            </div>
            <div class="pl-3 border-left mb-1" v-if="reply_message">
                <a href="#" @click.prevent="cancel_reply" class="float-right text-gray-500">
                    <i class="fas fa-times"></i>
                </a>
                <strong class="chat__message-user">{{ reply_message.user.name }}</strong>
                <p class="chat__message-body"><span v-html="reply_message.body"></span></p>
            </div>

            <div class="form-group has-feedback">
                <div class="col p-0">
                    <textarea v-bind:class="{ 'is-invalid': error }" @keydown="handleMessageInput" v-model="body" cols="30" rows="4" class="form-control chat__form-input"></textarea>

                    <a href="#" @click.prevent="addImage" class="text-muted chat__form-image">
                        <i class="h4 fa fa-camera"></i>
                    </a>
                </div>
            </div>

            <div v-if="images.length">
                <ul class="list-inline">
                    <li class="list-inline-item">Файлы: </li>
                    <li class="list-inline-item" v-for="image in images">{{ image.name }} [<a href="#" @click.prevent="deleteImage(image)">x</a>]</li>
                </ul>
            </div>

            <span class="chat__form-helptext" v-if="edited_message">
                <b>Enter</b> чтобы сохранить или <b>Shift + Enter</b> для переноса на новую строку
            </span>
            <span class="chat__form-helptext" v-else>
                <b>Enter</b> чтобы отправить или <b>Shift + Enter</b> для переноса на новую строку
            </span>
        </div>

        <input class="d-none" type="file" name="files[]" multiple />
    </form>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'
    import Bus from '../../../bus'
    import moment from 'moment'

    export default {
        data() {
            return {
                body: null,
                bodyBackedUp: null,
                touch: false,

                images: [],
                imagesBackedUp: [],

                edited_message: null,
                reply_message: null
            }
        },
        computed: mapGetters({
            chat: 'currentChat',
            error: 'messageError',
        }),
        methods: {
            ...mapActions([
                'createChatMessage',
                'editChatMessage'
            ]),
            moment: moment,
            isTouchDevice() {
                return true === ("ontouchstart" in window || window.DocumentTouch && document instanceof DocumentTouch);
            },
            handleMessageInput(e) {
                if (e.keyCode === 13 && !e.shiftKey) {
                    e.preventDefault();
                    this.send();
                }
            },
            addImage() {
                let input = document.createElement('input');
                input.type = 'file';

                input.onchange = e => {
                    let file = e.target.files[0];

                    this.images.push(file)
                };

                input.click();
            },
            deleteImage(image) {
                this.images = this.images.filter(function (i) {
                    return i !== image
                })
            },
            send() {
                if (!this.body || this.body.trim() === '') {
                    return
                }

                this.imagesBackedUp = this.images;
                this.images = [];

                this.bodyBackedUp = this.body;
                this.body = null;

                let reply = this.reply_message;
                this.cancel_reply();

                if (!this.edited_message) {
                    this.createChatMessage({
                        id: this.chat.id,
                        body: this.bodyBackedUp,
                        images: this.imagesBackedUp,
                        reply: reply,
                    }).then(() => {
                        if (this.error) {
                            this.body = this.bodyBackedUp;
                            this.images = this.imagesBackedUp
                        }
                    });
                } else {
                    let edited_m_id = this.edited_message.id;

                    this.cancel_edit();

                    this.editChatMessage({
                        id: this.chat.id,
                        body: this.bodyBackedUp,
                        message_id: edited_m_id,
                        reply: reply,
                    }).then(() => {
                        if (this.error) {
                            alert('😵 Ой-ой! Ошибка! 😵');
                            window.location.reload();
                        } else {
                            Bus.$emit('message.edited', {
                                id: edited_m_id,
                                time: moment()
                            })
                        }
                    });
                }
            },
            cancel_edit() {
                Bus.$emit('message.edit.canceled');

                this.edited_message = null;
                this.body = null;
            },
            cancel_reply() {
                this.reply_message = null;
            }
        },
        mounted() {
            Bus.$on('message.edit', (m) => {
                this.edited_message = m;
                this.body = m.body;
                this.reply_message = m.reply
            }).$on('message.reply', (m) => {
                this.reply_message = m;
            });

            this.touch = this.isTouchDevice()
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
                opacity: 0;
                display: block;
                text-align: center;
                transition: opacity 100ms ease-in 250ms;
            }
        }

        &__form:hover {
            .chat__form-image {
                opacity: 1 !important;
            }
        }
    }
</style>
