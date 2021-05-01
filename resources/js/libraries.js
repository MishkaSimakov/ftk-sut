// Vue (must be imported first!)
window.Vue = require('vue');

// Fontawesome
// require('@fortawesome/fontawesome-free/js/solid');
// require('@fortawesome/fontawesome-free/js/regular');
require('@fortawesome/fontawesome-free/js/all')

// infinite scroll for news and articles
// const infiniteScroll =  require('vue-infinite-scroll');
// Vue.use(infiniteScroll)

// lity for lightbox
import Lity from 'lity'


// Moment js
const moment = require('moment')
require('moment/locale/ru')
Vue.use(require('vue-moment'), {
    moment
})


// Vue calendar
// import VCalendar from 'v-calendar';
// Vue.use(VCalendar, {
//     componentPrefix: 'vc'
// });


// Autocomplete-vue
import Autocomplete from '@trevoreyre/autocomplete-vue'
Vue.use(Autocomplete)


// Tinymce rich text editor
import Editor from '@tinymce/tinymce-vue'
Vue.use(Editor)
