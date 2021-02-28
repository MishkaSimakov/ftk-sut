export default {
    async loadRating() {
        return new Promise((resolve, reject) => {
            axios.get(route('api.ratings.show')).then((response) => {
                resolve(response)
            })
        })
    }
}
