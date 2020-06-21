import api from '../api/all'
import moment from 'moment'
import Bus from '../../bus'

const state = {
    chat: null,
    loadingChat: true,
    loadingPage: true,
    messageError: false,
    currentPage: 0
};

const getters = {
    currentChat: state => {
        return state.chat
    },
    loadingChat: state => {
        return state.loadingChat
    },
    loadingPage: state => {
        return state.loadingPage
    },
    messageError: state => {
        return state.messageError
    },
    getChats: (state, getters, rootState) => {
        return rootState.chats.chats
    },
    getCurrentPage: state => {
        return state.currentPage;
    },
};

const actions = {
    buildTempMessage(chat_id, body, images, reply) {
        let tempId = Date.now();

        return {
            id: tempId,
            chat_id: chat_id,
            user: {
                name: window.Laravel.user.name
            },
            images: images.map((i) => {
                let url = URL.createObjectURL(i);

                return {
                    'url': url,
                    'width': null,
                    'height': null,
                }
            }),
            body: body,
            reply: reply,
            timeForHuman: moment().locale('ru').fromNow(),
            selfOwned: true,
            loading: true,
        }
    },
    getChat({dispatch, commit}, id) {
        commit('setChatLoading', true);
        state.loadingPage = true;

        if (state.chat) {
            Echo.leave('chat.' + state.chat.id)
        }

        api.getChat(id).then((response) => {
            response.data.messages = response.data.messages.reverse();

            commit('setChat', response.data);
            commit('setChatLoading', false);

            Bus.$emit(
                'chat.scroll',
                response.data.messages[response.data.messages.length - 1].id
            );

            actions.setRead({dispatch, commit}, id);

            state.currentPage = response.data.pageCount - 1;

            Echo.private('chat.' + id)
                .listen('ChatMessageCreated', (e) => {
                    e.message.selfOwned = false;
                    commit('appendToChat', e.message);

                    actions.setRead({dispatch, commit}, id);
                })
                .listen('ChatMessageUpdated', (e) => {
                    state.chat.messages = state.chat.messages.map((m) => {
                        if (m.id === e.message.id) {
                            m = e.message
                        }

                        return m
                    });

                    Bus.$emit('message.edited', {
                        id: e.message.id,
                        time: e.message.updated_at,
                    })
                })
        })
    },
    scrolled() {
        state.loadingPage = false;
    },
    loadChatPage({dispatch, commit}, id) {
        state.loadingPage = true;
        state.currentPage--;

        let first_message = state.chat.messages[0].id;

        api.loadChatPage(id, state.currentPage).then((response) => {
            state.chat.messages.unshift(...response.data.messages.reverse());

            Bus.$emit(
                'chat.scroll',
                first_message
            );
        });
    },
    createChatMessage({dispatch, commit}, {id, body, images, reply}) {
        let tempMessage = actions.buildTempMessage(id, body, images, reply);
        commit('appendToChat', tempMessage);
        Bus.$emit('chat.scroll', tempMessage.id);

        const formData = new FormData();

        images.forEach((x, key) => {
            formData.append('files[' + key + ']', x, x.name);
        });

        return api.storeChatMessage(id, {
            body: body,
            images: formData,
            reply_id: (reply ? reply.id : ""),
        }).then((response) => {
            if (response === "error") {
                commit("setMessageError", true);
                commit("removeChatMessage", tempMessage)
            } else {
                commit("setMessageError", false);

                state.chat.messages = state.chat.messages.map((m) => {
                    if (m.id === tempMessage.id) {
                        m.id = response.id;
                        m.images = response.images;

                        m.loading = false;
                    }

                    return m
                })
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
        commit('setChatUnreadState', false);

        Bus.$emit('chat.read', id);
    },
    editChatMessage({dispatch, commit}, {id, body, message_id, reply}) { //TODO: add images
        state.chat.messages = state.chat.messages.map((m) => {
            if (m.id === message_id) {
                m.body = body;
                m.reply = reply;
                m.is_edited = true
            }

            return m
        });

        return api.editChatMessage(id, {
            body: body,
            message_id: message_id,
            reply_id: (reply ? reply.id : ""),
        }).then((response) => {
            if (response === "error") {
                commit("setMessageError", true);
            } else {
                commit("setMessageError", false);
            }
        })
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
