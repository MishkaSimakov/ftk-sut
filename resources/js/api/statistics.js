export default {
    async loadRatingPointsStatistics({user}) {
        return new Promise((resolve, reject) => {
            axios.get(route('api.stat.points', {user: user})).then((response) => {
                resolve(response)
            })
        })
    },
    async loadArticlesStatistics({user}) {
        return new Promise((resolve, reject) => {
            axios.get(route('api.stat.articles', {user: user})).then((response) => {
                resolve(response)
            })
        })
    },
    async loadEventsStatistics({user}) {
        return new Promise((resolve, reject) => {
            axios.get(route('api.stat.events', {user: user})).then((response) => {
                resolve(response)
            })
        })
    },
}
