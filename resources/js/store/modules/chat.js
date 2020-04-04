import api from '../api/all'
import moment from 'moment'
import Bus from '../../bus'

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
    },
    getChats: (state, getters, rootState) => {
        return rootState.chats.chats
    }
};

const actions = {
    buildTempMessage(chat_id, body, images) {
        let tempId = Date.now();

        return {
            id: tempId,
            chat_id: chat_id,
            user: {
                name: window.Laravel.user.name
            },
            images: images.map((i) => {
                return URL.createObjectURL(i)
            }),
            body: body,
            timeForHuman: moment().locale('ru').fromNow(),
            selfOwned: true,
        }
    },
    getChat({dispatch, commit}, id) {
        commit('setChatLoading', true);

        if (state.chat) {
            Echo.leave('chat.' + state.chat.id)
        }

        api.getChat(id).then((response) => {
            commit('setChat', response.data);

            commit('setChatLoading', false);

            Echo.private('chat.' + id)
                .listen('ChatMessageCreated', (e) => {
                    e.message.selfOwned = false;
                    commit('appendToChat', e.message);
                })
                // .listen('ConversationUserCreated', (e) => {
                //     commit('updateUsersInConversation', e.data.users.data)
                // });
        })
    },
    createChatMessage({dispatch, commit}, {id, body, images}) {
        let tempMessage = actions.buildTempMessage(id, body, images);
        commit('appendToChat', tempMessage);

        const formData = new FormData();

        images.forEach((x, key) => {
            formData.append('files[' + key + ']', x, x.name);
        });

        return api.storeChatMessage(id, {
            body: body,
            images: formData
        }).then((response) => {
            if (response === "error") {
                commit("setMessageError", true);
                commit("removeChatMessage", tempMessage)
            } else {
                commit("setMessageError", false)
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
        return api.changeChatName(id, {
            name: name
        }).then((response) => {
            commit('updateChatName', response.data.name)
        });
    },
    removeChatUser({dispatch, commit}, {id, user}) {
        return api.removeChatUser(id, {
            user: user
        }).then((response) => {
            commit('updateUsersInChat', response.data.users)
        });
    },
    setRead({dispatch, commit}, id) {
        api.setRead(id);
        commit('setChatUnreadState', false)
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
        state.chat.messages.push(message)

        Bus.$emit('message.added', message)
    },
    setMessageError(state, status) {
        state.messageError = status
    },
    updateUsersInChat(state, users) {
        state.chat.users = users
    },
    updateChatName(state, name) {
        state.chat.name = name
    },
    removeChatMessage(state, message) {
        state.chat.messages = state.chat.messages.filter((m) => {
            return m.id !== message.id
        })
    },
    setChatUnreadState(state, status) {
        state.chat.isUnread = status
    }
};

export default {
    state,
    getters,
    mutations,
    actions
}
