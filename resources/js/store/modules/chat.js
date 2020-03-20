import api from '../api/all'

const state = {
    chat: null,
    loadingChat: true,
    messageError: false
};

const getters = {
    currentChat: state => {
        return state.chat
    },
    loadingChat: state => {
        return state.loadingChat
    },
    messageError: state => {
        return state.messageError
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
    createChatMessage({dispatch, commit}, {id, body}) {
        return api.storeChatMessage(id, {
            body: body
        }).then((response) => {
            if (response === "error") {
                commit("setMessageError", true)
            } else {
                commit("setMessageError", false)
                commit('appendToChat', response.data);
            }
        })
    },
    createChat({dispatch, commit}, {title, recipients}) {
        return api.storeChat({
            title: title,
            recipients: recipients,
        }).then((response) => {
            window.history.pushState(null, null, response.data);
            location.reload();
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
    appendToChat(state, message) {
        state.chat.messages.unshift(message)
    },
    setMessageError(state, status) {
        state.messageError = status
    }
};

export default {
    state,
    getters,
    mutations,
    actions
}
