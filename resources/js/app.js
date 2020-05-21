require('./bootstrap');
require('@fortawesome/fontawesome-free/js/all');

window.Vue = require('vue');

import Vuex from 'vuex';
Vue.use(Vuex);

require('./quill.js');
window.Quill = require('Quill');

import VueObserveVisibility from 'vue-observe-visibility'
Vue.use(VueObserveVisibility);

import loadComponents from './components';
loadComponents();

import store from './store/index.js'

const app = new Vue({
    el: '#app',
    store: store
});
