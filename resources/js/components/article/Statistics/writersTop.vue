<template>
    <div class="card mt-2">
        <div class="card-body">
            <h5 class="card-title">Лучшие авторы</h5>

            <ul class="nav nav-pills nav-fill" id="writers_top_tabs" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" data-toggle="tab" href="#bycount-tab" role="tab" aria-selected="true">По количеству</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#bypoints-tab" role="tab">По оценкам</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" data-toggle="tab" href="#byviews-tab" role="tab">По просмотрам</a>
                </li>
            </ul>

            <div v-if="loading" class="text-primary d-flex spinner-border my-4 mx-auto" role="status">
                <span class="sr-only">Загрузка...</span>
            </div>

            <div v-else>
                <div class="tab-content mt-4">
                    <div class="tab-pane fade show active" id="bycount-tab" role="tabpanel">
                        <div v-for="writer in writers.count" class="row">
                            <div :class="['text-truncate', 'col-9', 'col-md-8']">
                                <a :href="writer.url">{{ writer.name }}</a>
                            </div>

                            <div :class="['col-3', 'col-md-4', 'text-right', 'text-info']">
                                {{ writer.count }}<i class="d-none d-sm-inline ml-2 fas fa-newspaper"></i>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="bypoints-tab" role="tabpanel">
                        <div v-for="writer in writers.points" class="row">
                            <div :class="['text-truncate', 'col-9', 'col-md-8']">
                                <a :href="writer.url">{{ writer.name }}</a>
                            </div>

                            <div :class="['col-3', 'col-md-4', 'text-right', 'text-info']">
                                {{ writer.count }}<i class="d-none d-sm-inline ml-2 fas fa-heart"></i>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="byviews-tab" role="tabpanel">
                        <div v-for="writer in writers.views" class="row">
                            <div :class="['text-truncate', 'col-9', 'col-md-8']">
                                <a :href="writer.url">{{ writer.name }}</a>
                            </div>

                            <div :class="['col-3', 'col-md-4', 'text-right', 'text-info']">
                                {{ writer.count }}<i class="d-none d-sm-inline ml-2 fas fa-eye"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'url'
        ],
        data() {
            return {
                writers: [],
                loading: true
            }
        },
        mounted() {
            new Promise((resolve, reject) => {
                axios.get(this.url).then((response) => {
                    this.writers = response.data;
                    this.loading = false;
                })
            })
        }
    }
</script>
