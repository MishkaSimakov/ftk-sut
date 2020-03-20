import api from '../api/all'

const state = {
    chat: null,
    loadingChat: true
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
            console.log(response.data);

            commit('setChat', response.data);
            commit('setChatLoading', false);
        })
    },
    createChatMessage({dispatch, commit}, {id, body}) {
        return api.storeChatMessage(id, {
            body: body
        }).then((response) => {
            commit('appendToConversation', response.data.data)
            commit('prependToConversations', response.data.data.parent.data)
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
