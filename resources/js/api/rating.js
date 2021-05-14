export default {
    async loadRating({ period }) {
        return new Promise((resolve, reject) => {
            axios.get(route('api.rating.show', period)).then((response) => {
                resolve(response)
            })
        })
    }
}
