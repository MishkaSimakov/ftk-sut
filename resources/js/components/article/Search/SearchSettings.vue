<template>
    <div class="modal fade bd-example-modal-lg" id="chatSettingsForm" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Настройки поиска</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="mb-2">Теги</h4>

                                <div class="list-group">
                                    <button
                                        v-on:click="selectTag(tag.id)"
                                        v-for="(tag, i) in tags"
                                        type="button"
                                        :class="[
                                            'justify-content-between',
                                            'align-items-center',
                                            'list-group-item',
                                            'list-group-item-action',
                                            { 'font-weight-bold': i < 3},
                                            i >= 3 && !expanded && selectedTag !== tag.id ? 'd-none' : 'd-flex',
                                            { 'active': selectedTag === tag.id }
                                        ]"
                                    >
                                        {{ tag.name }} <span class="badge badge-primary badge-pill">{{ tag.article_count }}</span>
                                    </button>
                                </div>
                                <div class="w-100 text-center">
                                    <a style="user-select: none !important;" v-on:click.prevent="expandTags" href="#">{{ expanded ? 'Скрыть' : 'Показать все' }}</a>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <h4 class="mb-2">Сортировка</h4>

                                <div style="cursor: pointer; user-select: none !important;" :class="{ 'font-weight-bold': sort.views }" v-on:click="selectSort('views')">
                                    По просмотрам

                                    <span v-show="sort.views === 'asc'"><i class="float-right fas fa-sort-up"></i></span>
                                    <span v-show="sort.views === 'desc'"><i class="float-right fas fa-sort-down"></i></span>
                                </div>
                                <div style="cursor: pointer; user-select: none !important;" :class="{ 'font-weight-bold': sort.points }" v-on:click="selectSort('points')">
                                    По оценкам

                                    <span v-show="sort.points === 'asc'"><i class="float-right fas fa-sort-up"></i></span>
                                    <span v-show="sort.points === 'desc'"><i class="float-right fas fa-sort-down"></i></span>
                                </div>
                                <div style="cursor: pointer; user-select: none !important;" :class="{ 'font-weight-bold': sort.date }" v-on:click="selectSort('date')">
                                    По дате

                                    <span v-show="sort.date === 'asc'"><i class="float-right fas fa-sort-up"></i></span>
                                    <span v-show="sort.date === 'desc'"><i class="float-right fas fa-sort-down"></i></span>
                                </div>


                                <h4 class="my-2">Длина</h4>

                                <div class="form-check">
                                    <input class="form-check-input" v-model="articles_length.long" type="checkbox" value="long" id="long_articles_checkbox">
                                    <label style="user-select: none !important;" class="form-check-label" for="long_articles_checkbox">
                                        Длинные
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" v-model="articles_length.medium" type="checkbox" value="medium" id="medium_articles_checkbox">
                                    <label style="user-select: none !important;" class="form-check-label" for="medium_articles_checkbox">
                                        Средние
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" v-model="articles_length.short" type="checkbox" value="short" id="short_articles_checkbox">
                                    <label style="user-select: none !important;" class="form-check-label" for="short_articles_checkbox">
                                        Короткие
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal" v-on:click="applySettings">Применить</button>
                    <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Отменить</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Bus from '../../../bus'

    export default {
        data() {
            return {
                tags: [],
                selectedTag: null,
                expanded: false,

                sort: {
                    'views': null,
                    'points': null,
                    'date': null
                },
                sortMethods: [null, 'desc', 'asc'],

                articles_length: {
                    long: false,
                    medium: false,
                    short: false,
                }
            }
        },
        methods: {
            applySettings() {
                let url = new URL(window.location.href);
                url.searchParams.delete('tag');
                url.searchParams.delete('sort');
                url.searchParams.delete('length');

                if (this.selectedTag !== null) {
                    url.searchParams.set('tag', this.selectedTag);
                }

                for (let key in this.sort) {
                    if (this.sort[key]) {
                        url.searchParams.set('sort', key + '.' + this.sort[key]);
                    }
                }

                let length_query = [];
                for (let key in this.articles_length) {
                    if (this.articles_length[key]) {
                        length_query.push(key)
                    }
                }
                if (length_query.length) {
                    url.searchParams.set('length', length_query.join('.'));
                }

                history.pushState({}, null, url.href);
                Bus.$emit('articles.search.apply', url);
            },
            expandTags() {
                this.expanded = !this.expanded;
            },
            selectTag(id) {
                this.selectedTag = this.selectedTag === id ? null : id
            },
            selectSort(param) {
                for (let key in this.sort) {
                    if (key !== param) {
                        this.sort[key] = null
                    }
                }

                this.sort[param] = this.sortMethods[(this.sortMethods.indexOf(this.sort[param]) + 1) % 3]
            },
            setParams() {
                let url = new URL(window.location.href);

                this.selectedTag = url.searchParams.get('tag') ? parseInt(url.searchParams.get('tag')) : null;

                let sort = url.searchParams.get('sort') ? url.searchParams.get('sort').split('.') : [];
                this.sort[sort[0]] = sort[1];

                let article_length = url.searchParams.get('length') ? url.searchParams.get('length').split('.') : [];
                this.articles_length = {
                    long: article_length.indexOf('long') !== -1,
                    medium: article_length.indexOf('medium') !== -1,
                    short: article_length.indexOf('short') !== -1,
                }
            },
        },
        mounted() {
            new Promise((resolve, reject) => {
                axios.get('/webapi/articles/tags').then((response) => {
                    this.tags = response.data;

                    this.setParams()
                })
            });

            Bus.$on('articles.search.apply', this.setParams)
        }
    }
</script>

<style scoped>

</style>
