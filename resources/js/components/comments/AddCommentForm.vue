<template>
    <div class="input-group p-2 border-bottom">
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
</template>

<script>
    import {mapActions, mapGetters} from 'vuex'

    export default {
        props: [
          'article_id'
        ],
        data() {
            return {
                body: null,
                bodyBackedUp: null
            }
        },
        computed: mapGetters({
            error: 'commentError',
            sending: 'commentSending'
        }),
        methods: {
            ...mapActions([
                'createArticleComment'
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
        mounted() {
            if (window.location.hash === "#comments") {
                $('input').focus();
            }
        }
    }
</script>
