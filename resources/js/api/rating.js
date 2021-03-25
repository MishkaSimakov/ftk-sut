export default {
    async loadRating({ period }) {
        if (period) {
            period = period.start.replace('-', '.') + '-' + period.end.replace('-', '.')
        }

        return new Promise((resolve, reject) => {
            axios.get(route('api.rating.show', { period: period })).then((response) => {
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
