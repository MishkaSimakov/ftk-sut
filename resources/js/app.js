require('./bootstrap');
require('@fortawesome/fontawesome-free/js/all');

window.Vue = require('vue');

import Vuex from 'vuex';
Vue.use(Vuex);

require('./quill.js');
window.Quill = require('Quill');

// chat
Vue.component('chats', require('./components/chat/Chats.vue').default);
Vue.component('chat', require('./components/chat/Chat.vue').default);
Vue.component('message', require('./components/chat/Message.vue').default);
Vue.component('chat-users', require('./components/chat/ChatUsers.vue').default);

Vue.component('chat-button', require('./components/chat/ChatButton.vue').default);

Vue.component('chat-add-form', require('./components/chat/forms/ChatAddForm.vue').default);
Vue.component('message-add-form', require('./components/chat/forms/MessageAddForm.vue').default);
Vue.component('chat-user-add-form', require('./components/chat/forms/ChatUserAddForm.vue').default);
Vue.component('chat-name-form', require('./components/chat/forms/ChatNameForm.vue').default);

//comments
Vue.component('comments', require('./components/comments/Comments.vue').default);
Vue.component('comment', require('./components/comments/Comment.vue').default);
Vue.component('comment-add-form', require('./components/comments/AddCommentForm.vue').default);

// articles
Vue.component('tags-add-form', require('./components/article/AddTagForm.vue').default);

// rating
// Vue.component('rating', require('./components/rating/Rating.vue').default);

import store from './store/index.js'

const app = new Vue({
    el: '#app',
    store: store
});
