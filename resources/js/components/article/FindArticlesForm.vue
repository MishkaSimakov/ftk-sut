<template>
    <div class="mx-2">
        <div class="input-group p-2">
            <input v-on:keypress.enter.prevent="search" placeholder="Поиск статей..." type="text" v-model="query" id="query" class="form-control">

            <div class="input-group-append">
                <a class="btn btn-outline-primary" href="#" @click.prevent="search">
                    <span class="fa fa-search"></span>
                </a>
            </div>
        </div>

        <li class="list-inline text-truncate text-muted">
            <ul class="list-inline-item d-none d-md-inline">Популярные теги:</ul>
            <ul class="list-inline-item" v-for="tag in tags"><a href="#" @click.prevent="searchTag(tag)">{{ tag }}</a></ul>
        </li>

        <hr class="mt-0">
    </div>
</template>

<script>
    export default {
        data() {
            return {
                query: new URLSearchParams(window.location.search).get('query'),
                tags: []
            }
        },
        methods: {
            search() {
                let url = new URL(window.location.href);

                url.searchParams.set('query', this.query);

                window.location.href = url.href
            },
            searchTag(tag) {
                let url = new URL(window.location.href);

                url.searchParams.set('tag', tag);

                window.location.href = url.href
            }
        },
        mounted() {
            new Promise((resolve, reject) => {
                axios.get('/webapi/articles/tags').then((response) => {
                    this.tags = response.data
                })
            });
        }
    }
</script>
