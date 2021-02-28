import store from './store'

// Fontawesome
require('@fortawesome/fontawesome-free/js/all');

window.route = require('./route');

require('./bootstrap');

window.Vue = require('vue');

// infinite scroll for news and articles
const infiniteScroll =  require('vue-infinite-scroll');
Vue.use(infiniteScroll)

// Moment js
const moment = require('moment')
require('moment/locale/ru')

Vue.use(require('vue-moment'), {
    moment
})

require('./components/imports')


// Tinymce rich text editor
import Editor from '@tinymce/tinymce-vue'


const app = new Vue({
    store,
    el: '#app',

    components: {
        'editor': Editor
    }
});
