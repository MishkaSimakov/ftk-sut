require('./bootstrap');
require('@fortawesome/fontawesome-free/js/all');

window.Vue = require('vue');

import Vuex from 'vuex';
Vue.use(Vuex);

// chat
Vue.component('chats', require('./components/chat/Chats.vue').default);
Vue.component('chat', require('./components/chat/Chat.vue').default);
Vue.component('message', require('./components/chat/Message.vue').default);
Vue.component('chat-users', require('./components/chat/ChatUsers.vue').default);

Vue.component('chat-add-form', require('./components/chat/forms/ChatAddForm.vue').default);
Vue.component('message-add-form', require('./components/chat/forms/MessageAddForm.vue').default);
Vue.component('chat-user-add-form', require('./components/chat/forms/ChatUserAddForm.vue').default);
Vue.component('chat-name-form', require('./components/chat/forms/ChatNameForm.vue').default);

// rating
// Vue.component('rating', require('./components/rating/Rating.vue').default);

import store from './store/index.js'

const app = new Vue({
    el: '#app',
    store: store
});
