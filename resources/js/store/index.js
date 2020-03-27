import Vue from 'vue'
import Vuex from 'vuex'
import chats from "./modules/chats";
// import chat from "./modules/chat";
// import rating from "./modules/rating"
import comments from './modules/comments'

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        chats,
        comments,
        // rating
    }
})
