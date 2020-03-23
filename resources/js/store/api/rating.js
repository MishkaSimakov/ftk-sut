export default {
    getRating(id) {
        return new Promise((resolve, reject) => {
            axios.get('/api/rating/' + id).then((response) => {
                resolve(response)
            })
        })
    },
}
