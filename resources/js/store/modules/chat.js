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

        if (state.chat) {
            Echo.leave('chat.' + state.chat.id)
        }

        api.getChat(id).then((response) => {
            commit('setChat', response.data);
            commit('setChatLoading', false);

            Echo.private('chat.' + id)
                .listen('ChatMessageCreated', (e) => {
                    commit('appendToChat', e.message)
                })
                // .listen('ConversationUserCreated', (e) => {
                //     commit('updateUsersInConversation', e.data.users.data)
                // });
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
    addChatUsers({dispatch, commit}, {id, recipients}) {
        return api.storeChatUsers(id, {
            recipients: recipients
        }).then((response) => {
            commit('updateUsersInChat', response.data.users)
        })
    },
    changeChatName({dispatch, commit}, {id, name}) {
        // return api.changeChatName(id, {
        //     name: name
        // }).then((response) => {
        //     commit('updateChatName', response.data.name)
        // })

        console.log(name);
    }
};

const mutations = {
    setChat(state, chat) {
        state.chat = chat
    },
    setChatLoading(state, status) {
        state.loadingChat = status
    },
    appendToChat(state, message) {
        state.chat.messages.push(message)
    },
    setMessageError(state, status) {
        state.messageError = status
    },
    updateUsersInChat(state, users) {
        state.chat.users = users
    }
};

export default {
    state,
    getters,
    mutations,
    actions
}
