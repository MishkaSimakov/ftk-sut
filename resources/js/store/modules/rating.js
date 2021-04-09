import ratingApi from '../../api/rating'
import {isNumber} from "v-calendar/src/utils/_";

// initial state
const state = () => ({
    rating: [],
    period: {},
    categories: [],
    loading: true,
})

// getters
const getters = {
    getRatings: state => {
        return state.rating
    },
    getPeriod: state => {
        return state.period
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
    loadRating({state, dispatch, commit}, {period} = {period: null}) {
        if (period !== null) {
            if (period.start === state.period.start && period.end === state.period.end) {
                return
            }
        }

        commit('setLoading', true)

        Promise.all([
            ...(state.categories.length ? [] : [ratingApi.loadPointCategories()]),
            ratingApi.loadRating({period: period}),
        ]).then((response) => {
            if (state.categories.length === 0) {
                commit('setRatingCategories', response[0].data)
            }

            let rating_response = response.pop().data

            commit('setRatingPoints', rating_response.rating)
            state.period = rating_response.meta.period

            commit('setLoading', false)
        });
    },
    recountRating({state, commit}) {
        commit('setLoading', true)

        // recount total of each user
        let max = 0
        state.rating = state.rating.map((user) => {
            user.total = user.points.reduce((accumulator, point) => {
                return accumulator + (point.category.disabled ? 0 : point.amount)
            }, 0)
            user.points = user.points.map((point) => {
                point.width = point.category.disabled ? 0 : point.amount / user.total * 100
                return point
            })

            if (user.total > max) max = user.total

            return user
        })

        // recount width of bars
        state.rating = state.rating.map((user) => {
            user.width = user.total / max * 100
            return user
        })

        commit('setLoading', false)
    },
    setCategoriesFilter({state, dispatch, getters}, categories) {
        state.categories = state.categories.map((c) => {
            c.disabled = !(categories.includes(c.id) || categories.length === 0)

            return c
        })

        dispatch('recountRating')
    },
}

const mutations = {
    setLoading(state, status) {
        state.loading = status
    },
    setRatingCategories(state, categories) {
        categories.forEach((c) => {
            Vue.set(state.categories, c.id, c)
        })
    },
    setRatingPoints(state, points) {
        let max = Math.max(...points.map((u) => u.total))

        state.rating = points.map((user) => {
            user.width = user.total / max * 100
            user.points = user.points.map((point) => {
                point.category = state.categories[point.category]
                return point
            }).sort((a, b) => a.category.order - b.category.order)

            return user
        })
    }
}

export default {
    namespaced: true,

    state,
    getters,
    actions,
    mutations
}
