require('./bootstrap');
require('@fortawesome/fontawesome-free/js/all');

window.Vue = require('vue');

import Vuex from 'vuex';
Vue.use(Vuex);

Vue.component('chats', require('./components/chat/Chats.vue').default);
Vue.component('chat', require('./components/chat/Chat.vue').default);
// Vue.component('chat-add-form', require('./components/chat/forms/ChatAddForm.vue').default);

import store from './store/index.js'

const app = new Vue({
    el: '#app',
    store: store
});
