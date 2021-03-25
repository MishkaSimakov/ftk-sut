export default {
    async loadArticles({ page }) {
        return new Promise((resolve, reject) => {
            axios.get(route('api.article.index', { page: page })).then((response) => {
                resolve(response)
            })
        })
    }
}
