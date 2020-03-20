import api from '../api/all'

const state = {
    chat: null,
    loadingChat: false
};

const getters = {
    currentChat: state => {
        return state.chat
    },
    loadingChat: state => {
        return state.loadingChat
    }
};

const actions = {
    getChat({dispatch, commit}, id) {
        commit('setChatLoading', true)

        api.getChat(id).then((response) => {
            commit('setChat', response.data);
            commit('setChatLoading', false);
        })
    },
};

const mutations = {
    setChat(state, chat) {
        state.chat = chat
    },
    setChatLoading(state, status) {
        state.loadingChat = status
    },
};

export default {
    state,
    getters,
    mutations,
    actions
}
