<template>
    <div class="p-2 border-bottom">
        <div class="text-gray-500 mb-2" v-if="edited_comment">
            Редактирование комментария

            <a href="#" @click.prevent="cancel_edit" class="float-right text-gray-500">
                <i class="fas fa-times"></i>
            </a>
        </div>

        <div class="input-group">
            <input placeholder="Написать комментарий..." v-bind:class="{ 'is-invalid': error }" type="text" @keydown="handleCommentInput" v-model="body" id="body" class="form-control">

            <div class="input-group-append">
               <div v-if="sending" class="btn btn-outline-primary">
                   <div class="spinner-border-sm spinner-border mx-auto" role="status"></div>
               </div>

                <a v-else class="btn btn-outline-primary" href="#" @click.prevent="send">
                    <span class="fa fa-angle-right"></span>
                </a>
            </div>
        </div>
    </div>
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'
    import Bus from '../../bus'

    export default {
        props: [
          'article_id'
        ],
        data() {
            return {
                body: null,
                bodyBackedUp: null,
                edited_comment: null,
            }
        },
        computed: mapGetters({
            error: 'commentError',
            sending: 'commentSending'
        }),
        methods: {
            ...mapActions([
                'createArticleComment',
                'editArticleComment'
            ]),
            handleCommentInput(e) {
                if (e.keyCode === 13 && !e.shiftKey) {
                    e.preventDefault();
                    this.send();
                }
            },
            send() {
                if (!this.body || this.body.trim() === '') {
                    return
                }

                this.bodyBackedUp = this.body;
                this.body = null;

                if (this.edited_comment) {
                    this.editArticleComment({
                        comment: this.edited_comment.id,
                        body: this.bodyBackedUp
                    }).then(() => {
                        if (!this.error) {
                            this.cancel_edit();
                        }
                    })
                } else {
                    this.createArticleComment({
                        id: this.article_id,
                        body: this.bodyBackedUp
                    }).then(() => {
                        if (this.error) {
                            this.body = this.bodyBackedUp;
                        }
                    });
                }
            },
            cancel_edit() {
                this.edited_comment = null;
                this.body = null;
            }
        },
        mounted() {
            if (window.location.hash === "#comments") {
                $('input').focus();
            }

            Bus.$on('comment.edit', (m) => {
                $('input').focus();
                this.edited_comment = m;
                this.body = m.body;
            });
        }
    }
</script>
