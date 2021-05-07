// Vue (must be imported first!)
window.Vue = require('vue');

// infinite scroll for news and articles
// const infiniteScroll =  require('vue-infinite-scroll');
// Vue.use(infiniteScroll)

// lity for lightbox
import Lity from 'lity'

// fontawesome
import {library, dom} from '@fortawesome/fontawesome-svg-core'
import {
    faHeart as solidHeart,
    faEllipsisH,
    faArrowDown,
    faCog,
    faLongArrowAltRight,
    faTimes,
    faHiking,
    faBiking,
    faArrowRight,
    faArrowLeft
} from '@fortawesome/free-solid-svg-icons'
import {faHeart as regularHeart, faEye, faQuestionCircle} from '@fortawesome/free-regular-svg-icons'

library.add(
    faEllipsisH, faArrowDown, faCog, faLongArrowAltRight, solidHeart, faTimes, faHiking, faBiking, faArrowRight, faArrowLeft,
    regularHeart, faEye, faQuestionCircle
)
dom.watch()


// Vue calendar
// import VCalendar from 'v-calendar';
// Vue.use(VCalendar, {
//     componentPrefix: 'vc'
// });

// Dayjs
let dayjs = require('dayjs')
import 'dayjs/locale/ru' // load on demand

dayjs.locale('ru')

Object.defineProperties(Vue.prototype, {
    $date: {
        get() {
            return dayjs
        }
    }
});


// Autocomplete-vue
import Autocomplete from '@trevoreyre/autocomplete-vue'

Vue.use(Autocomplete)


// Tinymce rich text editor
import Editor from '@tinymce/tinymce-vue'

Vue.use(Editor)

// Datatables
// import {DataTable} from "simple-datatables"
// window.DataTable = DataTable
