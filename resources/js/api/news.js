export default {
    async loadNews({ sortType, page }) {
        return new Promise((resolve, reject) => {
            axios.get(route('api.news.index', { page: page, sortType: sortType })).then((response) => {
                resolve(response)
            })
        })
    }
}
