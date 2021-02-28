import ratingApi from '../../api/rating'

// initial state
const state = () => ({
    ratings: [],
    loading: false,
})

// getters
const getters = {
    getNews: state => {
        return state.ratings
    },
    isLoading: state => {
        return state.loading
    }
}

// actions
const actions = {
    loadRating({ commit, state }) {
        state.loading = true

        ratingApi.loadRating().then((response) => {
            state.rating = response.data

            state.loading = false
        })
    },
}

export default {
    state,
    getters,
    actions
}
