import Vue from 'vue'
import Vuex from 'vuex'
import chats from "./modules/chats";
import chat from "./modules/chat";

Vue.use(Vuex);

export default new Vuex.Store({
    modules: {
        chats,
    }
})
