import api from '../api/rating'

const state = {
    loading: true,
    rating: null,
    chartData: null
};

const getters = {
    rating: state => {
        return state.rating
    },
    loading: state => {
        return state.loading
    }
};

const actions = {
    getRating({dispatch, commit}, id) {
        commit('setRatingLoading', true);

        api.getRating(id).then((response) => {
            commit('setRating', response.data);
            commit('setRatingLoading', false);
        })
    }
};

const mutations = {
    setRating(state, rating) {
        state.rating = rating
    },
    setRatingLoading(state, status) {
        state.loading = status
    },
    setChartData(state, data) {
        state.chartData = data
    }
};

export default {
    state,
    getters,
    mutations,
    actions
}
