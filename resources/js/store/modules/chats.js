import api from '../api/all'
import chat from "./chat";

const state = {
    chats: [],
    loadingChats: true
};

const getters = {
    allChats: state => {
        return state.chats
    },
    loadingChats: state => {
        return state.loadingChats
    }
};

const actions = {
    getChats({dispatch, commit}, page) {
        commit('setChatsLoading', true);

        api.getChats(1).then((response) => {
            Echo.private(`user.${window.Laravel.user.id}`)
                .listen('ChatCreated', (e) => {
                    commit('prependToChats', e.chat)
                })
                .listen('ChatMessageCreated', (e) => {
                    commit('setChatToUnread', e.message.chat)
                })

            commit('setChats', response.data);

            commit('setChatsLoading', false)
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
        var full_chat = null;

        state.chats.forEach((c) => {
            if (c.id === chat.id) {
                full_chat = c
            }
        });

        full_chat.isUnread = true;

        state.chats = state.chats.filter((c) => {
            return c.id !== chat.id
        });

        state.chats.unshift(full_chat)
    }
};

export default {
    state,
    getters,
    mutations,
    actions,
    modules
};

