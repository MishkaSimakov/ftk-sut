export default {
    async loadRatingPointsStatistics({user}) {
        return new Promise((resolve, reject) => {
            axios.get(route('api.stat.points', {user: user})).then((response) => {
                resolve(response)
            })
        })
    },
}
