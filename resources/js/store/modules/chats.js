import api from '../api/all'
import chat from "./chat";

const state = {
    chats: [],
    loadingChats: true,
    deletingChatId: null,
};

const getters = {
    allChats: state => {
        return state.chats
    },
    loadingChats: state => {
        return state.loadingChats
    },
    deletingChatId: state => {
        return state.deletingChatId
    },
    unreadCount: state => {
        let unread_count = 0;

        state.chats.forEach((chat) => {
            if (chat.isUnread) {
                unread_count++;
            }
        });

        return unread_count
    }
};

const actions = {
    getChats({dispatch, commit}, page) {
        commit('setChatsLoading', true);

        api.getChats(1).then((response) => {
            Echo.private(`user.${window.Laravel.user.id}`)
                .listen('ChatCreated', (e) => {
                    e.chat.selfOwned = false;

                    commit('prependToChats', e.chat)
                })
                .listen('ChatMessageCreated', (e) => {
                    commit('setChatToUnread', e.message.chat)
                })

            commit('setChats', response.data);

            commit('setChatsLoading', false)
        })
    },
    deleteChat({commit, dispatch}, chat) {
        commit('setDeletingChat', chat.id);

        api.removeChat(chat.id).then((response) => {
            commit('deleteFromChatList', chat);

            commit('setDeletingChat', null);
        })
    }
};

const modules = {
    chat: chat
};

const mutations = {
    setChats(state, chats) {
        state.chats = chats
    },
    setChatsLoading(state, status) {
        state.loadingChats = status
    },
    prependToChats(state, chat) {
        state.chats = state.chats.filter((c) => {
            return c.id !== chat.id
        });

        state.chats.unshift(chat)
    },
    setChatToUnread(state, chat) {
        let full_chat = state.chats.find(function (c) {
            return c.id === chat.id
        });

        full_chat.isUnread = true;

        state.chats = state.chats.filter((c) => {
            return c.id !== chat.id
        });

        state.chats.unshift(full_chat)
    },
    deleteFromChatList(state, chat) {
        state.chats = state.chats.filter((c) => {
            return c.id !== chat.id
        })
    },
    setDeletingChat(state, chat) {
        state.deletingChatId = chat
    }
};

export default {
    state,
    getters,
    mutations,
    actions,
    modules
};

