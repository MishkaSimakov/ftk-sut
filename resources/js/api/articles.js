export default {
    async loadArticles({ page }) {
        return new Promise((resolve, reject) => {
            axios.get(route('api.articles.index', { page: page })).then((response) => {
                resolve(response)
            })
        })
    }
}
