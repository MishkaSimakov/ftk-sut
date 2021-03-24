import articlesApi from '../../api/articles'

// initial state
const state = () => ({
    articles: [],
    page: 1,

    isLoading: false,
    isEnded: false
})

// getters
const getters = {
    getArticles: (state) => {
        return state.articles
    },
    isScrollDisabled: (state) => {
        return state.isLoading || state.isEnded
    }
}

// actions
const actions = {
    loadArticles({ commit, state }) {
        state.loading = true

        articlesApi.loadArticles({
            page: state.page
        }).then((response) => {
            if (response.data.length === 0) {
                state.isEnded = true
                return
            }

            state.articles.push(...response.data)

            state.loading = false
        })

        state.page += 1
    },
}

export default {
    namespaced: true,

    state,
    getters,
    actions
}
