<template>
    <div>
        <div class="input-group my-2">
            <input v-on:keypress.enter.prevent="search" placeholder="Поиск статей..." type="text" v-model="query" id="query" class="form-control">

            <div class="input-group-append">
                <button class="btn btn-outline-primary" type="button" @click.prevent="search">
                    <i class="fa fa-search"></i>
                </button>
                <button class="btn btn-outline-secondary rounded-right" v-on:click="openSettings" type="button" title="Настройки поиска">
                    <i class="fa fa-cog"></i>
                </button>
            </div>

            <search-settings ref="settings" :tags="tags"></search-settings>
        </div>

<!--        <div v-if="tags.length" class="mb-2 card shadow w-100">-->
<!--            <div class="card-body py-2 row">-->
<!--                <ul class="list-unstyled mb-0 col-md-10 text-truncate" style="text-overflow: clip !important;">-->
<!--                    <li class="list-inline-item " v-for="tag in tags"><a href="#" @click.prevent="searchTag(tag)">{{ tag }}</a></li>-->
<!--                </ul>-->

<!--                <div class="col-md-2">-->
<!--                    <i class="fas fa-cogs float-right my-auto "></i>-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
    </div>
</template>

<script>
    import Bus from '../../../bus'

    export default {
        data() {
            return {
                query: new URLSearchParams(window.location.search).get('query'),
                tags: [],
            }
        },
        methods: {
            openSettings() {
                $(this.$refs.settings.$el).modal('show')
            },
            search() {
                let url = new URL(window.location.href);

                if (this.query.trim()) {
                    url.searchParams.set('query', this.query);
                } else {
                    url.searchParams.delete('query');
                }

                history.pushState({}, null, url.href);
                Bus.$emit('articles.search.apply', url);
            },
        }
    }
</script>
