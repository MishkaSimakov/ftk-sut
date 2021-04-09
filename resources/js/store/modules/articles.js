import articlesApi from '../../api/articles'

// initial state
const state = () => ({
    articles: [],
    tags: [],
    page: 1,

    isLoading: false,
    isEnded: false
})

// getters
const getters = {
    getArticles: (state) => {
        return state.articles
    },
    getTags: (state) => {
        return state.tags.sort((a, b) => { return b.articles_count - a.articles_count })
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
    loadTags({ commit, state }) {
        articlesApi.loadTags().then((response) => {
            state.tags = response.data
        })
    },
    togglePoint({ commit, state }, { article_id }) {
        if (window.Laravel.user) {
            articlesApi.togglePoint(article_id).then((response) => {

            });
        }
    }
}

export default {
    namespaced: true,

    state,
    getters,
    actions
}
