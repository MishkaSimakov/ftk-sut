export default {
    async loadRating({ period }) {
        period = period.start.replace('-', '.') + '-' + period.end.replace('-', '.')

        return new Promise((resolve, reject) => {
            axios.get(route('api.ratings.show', { period: period })).then((response) => {
                resolve(response)
            })
        })
    }
}
