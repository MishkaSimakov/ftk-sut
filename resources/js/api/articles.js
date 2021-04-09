export default {
    async loadArticles({ page }) {
        return new Promise((resolve, reject) => {
            axios.get(route('api.article.index', { page: page })).then((response) => {
                resolve(response)
            })
        })
    },
    async loadTags() {
        return new Promise((resolve, reject) => {
            axios.get(route('api.article.tags')).then((response) => {
                resolve(response)
            })
        })
    },
    async togglePoint(article_id) {
        return new Promise((resolve, reject) => {
            axios.post(route('api.article.points.toggle', { article: article_id, user: window.Laravel.user.id })).then((response) => {
                resolve(response)
            })
        })
    },
}
