import newsApi from '../../api/news'

// initial state
const state = () => ({
    news: [],
    sortType: 'fresh',
    page: 1,

    isLoading: false,
    isEnded: false
})

// getters
const getters = {
    getNews: (state) => {
        return state.news
    },
    getSortType: (state) => {
        return state.sortType
    },
    isScrollDisabled: (state) => {
        return state.isLoading || state.isEnded
    }
}

// actions
const actions = {
    loadNews({ commit, state }, { sortType }) {
        state.loading = true

        if (sortType !== state.sortType) {
            state.page = 1
            state.news = []
            state.isEnded = false
        }

        state.sortType = sortType

        newsApi.loadNews({
            sortType: sortType,
            page: state.page
        }).then((response) => {
            if (response.data.length === 0) {
                state.isEnded = true
                return
            }

            state.news.push(...response.data)

            state.loading = false
        })

        state.page += 1
    },
    setSortType({ dispatch, state }, sortType) {
        if (sortType !== state.sortType) {
            dispatch('loadNews', { sortType: sortType })
        }
    }
}

export default {
    state,
    getters,
    actions
}
