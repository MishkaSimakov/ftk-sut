import ratingApi from '../../api/rating'

// initial state
const state = () => ({
    rating: [],
    categories: [],
    loading: false,
})

// getters
const getters = {
    getRatings: state => {
        return state.rating
    },
    getCategories: state => {
        return state.categories
    },
    getCategory: state => id => {
        return state.categories.filter((c) => c.id === id)[0]
    },
    getSortedRating: state => {
        return state.rating.sort((a, b) => b.total - a.total)
    },
    isLoading: state => {
        return state.loading
    }
}

// actions
const actions = {
    loadRating({state, dispatch}, period) {
        state.loading = true

        ratingApi.loadRating({period: period}).then((response) => {
            state.rating = response.data.rating
            state.categories = response.data.categories

            dispatch('recountRating', {
                recountTotal: false,
                recountCategoryWidth: false
            })

            state.loading = false
        })
    },
    recountRating({state, commit, getters}, {recountTotal, recountCategoryWidth}) {
        state.loading = true

        // recount total of each user
        if (recountTotal) {
            state.rating = state.rating.map((user) => {
                user.total = user.points.reduce((accumulator, point) => {
                    return accumulator + (getters.getCategory(point.category.id).disabled ? 0 : point.amount)
                }, 0)

                return user
            })
        }
        let max = Math.max(...state.rating.map((u) => u.total))


        // recount width of bars
        state.rating = state.rating.map((user) => {
            user.width = user.total / max * 100

            if (recountCategoryWidth) {
                user.points = user.points.map((point) => {
                    point.width = getters.getCategory(point.category.id).disabled ? 0 : point.amount / user.total * 100

                    return point
                })
            }

            return user
        })

        state.loading = false
    },
    setCategoriesFilter({state, dispatch}, categories) {
        state.categories = state.categories.map((c) => {
            c.disabled = categories[c.id]
            return c
        })

        dispatch('recountRating', {
            recountTotal: true,
            recountCategoryWidth: true
        })
    },
}

export default {
    namespaced: true,

    state,
    getters,
    actions
}
