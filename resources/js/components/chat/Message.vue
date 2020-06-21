<template>
    <div :id="'message_' + message.id" class="chat__message" :class="[{ 'chat__message--own' : message.selfOwned }, { 'chat__message--unread' : isUnread }, { 'chat__message--replied' : is_replied}]">
        <strong class="font-weight-bolder">{{ message.user.name }}</strong>
        <span data-toggle="tooltip" :data-title="moment(message.created_at).locale('ru').calendar().toLowerCase()" class="chat__message-timestamp d-none d-md-inline" v-if="!is_replied">{{ moment(message.created_at).locale('ru').fromNow() }}</span>

        <div class="row mr-2 float-right chat__message-other" v-if="!is_replied">
            <div v-if="!message.loading && !message.reply && !is_editing" class="mr-2">
                <a href="#" @click.prevent="reply" title="Ответить"><i class="small fa fa-reply"></i></a>
            </div>

            <div v-if="message.selfOwned">
                <div v-if="message.loading">
                    <div style="opacity: 1!important;" class="spinner-border-sm spinner-border mx-auto text-info" role="status"></div>
                </div>

                <div v-else>
                    <a v-if="moment(message.created_at).isAfter(moment().subtract(2, 'hours'))" href="#" @click.prevent="edit" title="Редактировать"><i class="small fa fa-pen"></i></a>
                </div>
            </div>
        </div>

        <message v-if="message.reply" is_replied="true" v-bind:message="message.reply"></message>

        <p class="chat__message-body"><span v-html="link(message.body)"></span><span v-if="message.is_edited" class="text-muted ml-2" v-bind:id="'tooltip_message_' + message.id">(ред.)</span></p>

        <div class="row" v-if="message.images && message.images.length">
            <div v-for="image in message.images" class="rounded m-2 border chat__message-image_container" :style="getImageSize(image)">
                <img
                    alt="Картинка"
                    class="h-100 w-100 rounded chat__message-image"
                    v-bind:src="image.url"
                    data-lity
                >
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'
    import Bus from '../../bus'
    import link from '../../helpers/link'

    export default {
        props: [
            'message',
            'is_replied'
        ],
        data() {
          return {
              is_editing: false,
              isUnread: moment()
          };
        },
        methods: {
            moment: moment,
            link: link,
            getImageSize(image) {
                let width = 'auto';
                let height = 'auto';
                let relation = 1;

                if (image.width && image.height) {
                    height = image.height + 'px';
                    width = image.width + 'px';

                    relation = image.width / image.height;
                }

                return `width:${width}; height:${height}; max-height:10rem; max-width:${10 * relation}rem;`;
            },
            edit() {
                this.is_editing = true;
                Bus.$emit('message.edit', this.message);
            },
            reply() {
                Bus.$emit('message.reply', this.message);
            }
        },
        mounted() {
            if (this.message.is_edited) {
                $('#tooltip_message_' + this.message.id).tooltip({
                    title: 'изменено ' + moment(this.message.updated_at).locale('ru').calendar().toLowerCase(),
                })
            }

            Bus.$on('message.edit.canceled', () => {
                this.is_editing = false;
            });
        }
    }
</script>

<style lang="scss">
    .chat {
        &__message {
            padding: 15px;
            border-bottom: 1px solid #eee;

            &-timestamp {
                margin-left: 10px;
                color: #aaa;
            }

            &-body {
                margin-bottom: 0;
                white-space: pre-wrap;
            }

            &--own {
                background-color: #f0f0f0;
            }

            &--replied {
                border-left: 1px solid lightgray;

                padding: 0.25rem 0 0.25rem 1rem;
                margin: 0.25rem 0;
            }

            &-image {
                max-height: 10rem;
                /*max-width: 10rem;*/
                cursor: pointer;
                /*object-fit: cover;*/
                /*object-position: center;*/
            }

            &-image_container {
                animation-duration: 1.8s;
                animation-fill-mode: forwards;
                animation-iteration-count: infinite;
                animation-name: placeHolderShimmer;
                animation-timing-function: linear;
                background: #f6f7f8;
                background: linear-gradient(to right, #fafafa 8%, #f4f4f4 38%, #fafafa 54%);
                background-size: 1000px 640px;

                @keyframes placeHolderShimmer{
                    0%{
                        background-position: -468px 0
                    }
                    100%{
                        background-position: 468px 0
                    }
                }
            }

            &-other {
                opacity: 0;
                transition: opacity 100ms ease 100ms;
            }
        }

        &__message:hover {
            .chat__message-other {
                opacity: 1;
            }
        }
    }
</style>
