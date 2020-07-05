<template>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Недавняя активность</h5>

            <ul class="nav nav-pills nav-fill" id="action_tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#comments-tab" role="tab" aria-selected="true">Комментарии</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#articles-tab" role="tab">Статьи</a>
                </li>
            </ul>

            <div v-if="loading" class="text-primary d-flex spinner-border my-4 mx-auto" role="status">
                <span class="sr-only">Загрузка...</span>
            </div>

            <div v-else>
                <div class="tab-content mt-4">
                    <div class="tab-pane fade show active" id="comments-tab" role="tabpanel" aria-labelledby="profile-tab">
                        <div v-for="article in actions.comments" class="row">
                            <div :class="['text-truncate', 'col-9', 'col-md-8']">
                                <a :href="article.url">{{ article.title }}</a>
                            </div>

                            <div :class="['col-3', 'col-md-4', 'text-right', 'text-info']">
                                + {{ article.comments }}<i class="d-none d-sm-inline ml-2 fas fa-comment"></i>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="articles-tab" role="tabpanel" aria-labelledby="profile-tab">
                        <div v-for="article in actions.articles" class="row">
                            <div :class="['text-truncate', 'col-6', 'col-md-8']">
                                <a :href="article.url">{{ article.title }}</a>
                            </div>

                            <div :class="['col-6', 'col-md-4', 'text-right', 'text-info']">
                                {{ moment(article.created_at).locale('ru').fromNow() }}<i class="d-none d-sm-inline ml-2 fas fa-calendar"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment'

    export default {
        props: [
            'url'
        ],
        data() {
            return {
                actions: [],
                loading: true,
            }
        },
        methods: {
            moment: moment,
        },
        mounted() {
            new Promise((resolve, reject) => {
                axios.get(this.url).then((response) => {
                    this.actions = response.data;
                    this.loading = false;
                })
            })
        }
    }
</script>
