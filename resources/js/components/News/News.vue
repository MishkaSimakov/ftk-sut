<template>
    <div class="card mb-3">
        <div class="card-body pb-2">
            <h5 class="card-title">{{ news.title }}</h5>
            <div class="card-text" v-html="news.body"></div>

            <div class="row no-gutters text-muted mt-1">
                <div class="card-text align-self-center">
                    {{ $moment(news.date).format('ll') }}
                </div>

                <div class="ml-auto row no-gutters">
                    <span class="align-self-center mr-sm-2" style="font-weight: 500;">
                        <i class="far fa-eye"></i> {{ news.views }}
                    </span>

                    <div v-if="isAdmin" class="dropdown">
                        <button class="d-inline btn rounded-pill text-muted" type="button"
                                id="news-more-dropdown-button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-h fa-sm"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="news-more-dropdown-button">
                            <a class="dropdown-item" :href="route('news.edit', { news: news.id })">Редактировать</a>
                            <a class="dropdown-item text-danger" href="#" v-on:click.prevent="deleteNews">
                                Удалить
                            </a>

                            <form :id="destroyFormId" class="d-none" method="POST"
                                  :action="route('news.destroy', { news: news.id })">
                                <input type="hidden" name="_token" :value="csrf">
                                <input type="hidden" name="_method" value="DELETE">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            destroyFormId: `destroy_form_${this.news.id}`,
            csrf: window.Laravel.csrfToken,
            isAdmin: window.Laravel.user.is_admin
        }
    },
    props: {
        news: Object,
    },
    methods: {
        route: route,
        deleteNews() {
            $(`#${this.destroyFormId}`).submit()
        }
    }
}
</script>

<style scoped>

</style>
