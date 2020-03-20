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
            // Echo.private(`user.${window.user.id}`)
            //     .listen('ConversationCreated', (e) => {
            //         commit('prependToConversations', e.data)
            //     })
            //     .listen('ConversationReplyCreated', (e) => {
            //         commit('prependToConversations', e.data.parent.data)
            //     })
            //     .listen('ConversationUserCreated', (e) => {
            //         commit('updateConversationInList', e.data)
            //     });

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
};

export default {
    state,
    getters,
    mutations,
    actions,
    modules
};

