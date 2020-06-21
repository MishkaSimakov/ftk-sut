<template>
    <div>
        <div class="d-inline" :id='"article_like_" + article.id'>
            <span v-if="auth" :class="isLiked ? 'article__liked' : 'article__unliked'">
                <a class="article__unlike_link" v-on:click="unlike" v-if="isLiked"><i style="cursor: pointer;" class="fas fa-heart"></i></a>
                <a class="article__like_link" v-on:click="like" v-else><i style="cursor: pointer;" class="far fa-heart"></i></a>


                <span class="article__like_counter" :id="'article_like_counter_' + article.id">{{ article.users.length }}</span>
            </span>
            <span v-else class="article__liked">
                <i class="article__unlike_link fas fa-heart"></i>

                <span class="article__like_counter" :id="'article_like_counter_' + article.id">{{ article.users.length }}</span>
            </span>
        </div>

        <div class="ml-4 d-inline-block">
            <a :href="article.url + '#comments'" class="article__comment_link">
                <i style="cursor: pointer;" class="far fa-comment"></i>
            </a>

            <span class="article__comments_counter">{{ article.comments.length }}</span>
        </div>

        <div class="ml-4 d-inline-block">
            <a class="article__comment_link">
                <i class="far fa-eye"></i>
            </a>

            <span class="article__comments_counter">{{ article.views }}</span>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'data',
            'auth',
            'url'
        ],
        computed: {
            article: function() {
                return JSON.parse(this.data)
            },
        },
        data() {
            return {
                isLiked: false,
            }
        },
        methods: {
            like() {
                this.article.users.unshift({
                    name: window.Laravel.user.name
                });

                this.updateUsers();

                $.ajax({
                    url: this.url,
                    method: "POST",
                    dataType: 'json',
                    data: {
                        user_id: window.Laravel.user.id,
                        type: 'like'
                    },
                    success: function (response) {
                        if (response === 'error') {
                            alert('Что-то пошло не так. Мы уже работаем над этим.');

                            this.article.users = this.article.users.filter((u) => {
                                return u.id !== window.Laravel.user.id
                            });

                            this.updateUsers()
                        }
                    }
                });
            },
            unlike() {
                this.article.users = this.article.users.filter((u) => {
                   return u.id !== window.Laravel.user.id
                });

                console.log(this.article,  this.article.users.filter((u) => {
                    return u.id !== window.Laravel.user.id
                }));

                this.updateUsers();

                $.ajax({
                    url: this.url,
                    method: "POST",
                    dataType: 'json',
                    data: {
                        user_id: window.Laravel.user.id ,
                        type: 'unlike'
                    },
                    success: function (response) {
                        if (response === 'error') {
                            alert('Что-то пошло не так. Мы уже работаем над этим.');

                            this.article.users.unshift({
                                name: window.Laravel.user.name
                            });

                            this.updateUsers()
                        }
                    }
                });
            },
            updateUsers() {
                this.isLiked = !!this.article.users.find((u) => {
                    return u.id == window.Laravel.user.id
                });

                if (this.article.users.length) {
                    $('#article_like_' + this.article.id).tooltip('dispose').tooltip({
                        title: this.article.users > 1 ? 'Оценили: ' : 'Оценил: ' + this.article.users.map((u) => {
                            return u.name
                        }).join(', '),
                    })
                }
            }
        },
        mounted() {
            this.updateUsers()
        }
    }
</script>
