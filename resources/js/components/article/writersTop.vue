<template>
    <div class="card">
        <div class="card-header py-3">
            <h4 class="font-weight-bold text-primary">
                Топ авторов
            </h4>
        </div>

        <div class="card-body">
            <ol class="my-2">
                <li v-for="user in users">
                    <a v-bind:href="user.url">{{ user.name }}</a>

                    <span class="ml-3 text-primary float-right">
                        <i class="far fa-newspaper"></i> {{ user.articleCount }}
                    </span>
                </li>
            </ol>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                users: []
            }
        },
        mounted() {
            new Promise((resolve, reject) => {
                axios.get('/webapi/articles/top').then((response) => {
                    this.users = response.data;
                })
            })
        }
    }
</script>
