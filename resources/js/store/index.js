import Vue from 'vue'
import Vuex from 'vuex'

import news from './modules/news'
import articles from './modules/articles'
import rating from './modules/rating'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        news,
        articles,
        rating
    }
})
