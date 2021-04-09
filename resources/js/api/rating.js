export default {
    async loadRating({ period }) {
        return new Promise((resolve, reject) => {
            axios.get(route('api.rating.show', period)).then((response) => {
                resolve(response)
            })
        })
    },
    async loadPointCategories() {
        return new Promise((resolve, reject) => {
            axios.get(route('api.rating.categories')).then((response) => {
                resolve(response)
            })
        })
    }
}
