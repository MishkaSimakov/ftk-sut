import api from '../api/comment'

const state = {
    comments: [],
    loadingComments: true,
    commentError: false,
    sendComment: false
};

const getters = {
    allComments: state => {
        return state.comments
    },
    loadingComments: state => {
        return state.loadingComments
    },
    commentError: state => {
        return state.commentError
    },
    commentSending: state => {
        return state.sendComment
    }
};

const actions = {
    getComments({dispatch, commit}, id) {
        commit('setCommentsLoading', true);

        api.getComments(id).then((response) => {
            commit('setComments', response.data);

            commit('setCommentsLoading', false)
        })
    },
    createArticleComment({dispatch, commit}, {id, body}) {
        commit('setCommentSending', true);

        return api.storeArticleComment(id, {
            body: body
        }).then((response) => {
            if (response === "error") {
                commit("setCommentError", true)
                // commit("removeChatMessage", tempMessage)
            } else {
                commit("setCommentError", false)

                commit('appendToComments', response.data)
            }

            commit('setCommentSending', false);
        })
    },
    editArticleComment({dispatch, commit}, {comment, body}) {
        commit('setCommentSending', true);

        return api.editArticleComment(comment, {
            body: body
        }).then((response) => {
            if (response === "error") {
                commit("setCommentError", true)
            } else {
                commit("setCommentError", false);

                state.comments = state.comments.map((c) => {
                    if (c.id === comment) {
                        c.body = body;
                    }

                    return c;
                })
            }

            commit('setCommentSending', false);
        })
    }
};

const mutations = {
    setComments(state, comments) {
        state.comments = comments
    },
    setCommentsLoading(state, status) {
        state.loadingComments = status
    },
    setCommentError(state, status) {
        state.commentError = status
    },
    setCommentSending(state, status) {
        state.sendComment = status
    },
    appendToComments(state, comment) {
        state.comments.unshift(comment)
    }
};

export default {
    state,
    getters,
    mutations,
    actions,
};

