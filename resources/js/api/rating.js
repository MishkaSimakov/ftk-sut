export default {
    async loadRating({period}, loadingRouteName) {
        return new Promise((resolve, reject) => {
            axios.get(route(loadingRouteName, period)).then((response) => {
                resolve(response)
            })
        })
    }
}
