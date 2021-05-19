import Vue from 'vue'
import Vuex from 'vuex'

import rating from './modules/rating'

Vue.use(Vuex)

export default new Vuex.Store({
    modules: {
        rating
    }
})
