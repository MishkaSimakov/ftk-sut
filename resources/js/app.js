import store from './store'

// helpers
require('./helpers/imports')

// Laravel and bootstrap stuff
require('./bootstrap');

// Libraries
require('./libraries')

// Vue stuff
require('./components/imports')

const app = new Vue({
    store,
    el: '#app',
});
