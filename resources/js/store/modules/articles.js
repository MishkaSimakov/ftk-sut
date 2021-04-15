import articlesApi from '../../api/articles'

// initial state
const state = () => ({
    articles: [],
    best_articles: [],

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
    getBestArticles: (state) => {
        return state.best_articles
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

        Promise.all([
            ...(state.best_articles.length ? [] : [articlesApi.loadBestArticles()]),
            articlesApi.loadArticles({
                page: state.page
            }),
        ]).then((response) => {
            if (state.best_articles.length === 0) {
                commit('setBestArticles', response[0].data)
            }

            let articles = response.pop().data
            commit('setArticles', articles)

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

const mutations = {
    setBestArticles(state, best_articles) {
        state.best_articles = best_articles
    },
    setArticles(state, articles) {
        if (articles.length === 0) {
            state.isEnded = true
        } else {
            state.articles.push(...articles)
        }
    }
}

export default {
    namespaced: true,

    state,
    getters,
    actions,
    mutations
}
