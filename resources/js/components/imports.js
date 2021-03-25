// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// news
Vue.component('news-list', require('./news/NewsList').default);
Vue.component('news-editor', require('./news/NewsEditor').default);


// articles
Vue.component('articles-list', require('./articles/Lists/ArticlesList').default);
Vue.component('articles-editor', require('./Articles/Form/ArticleBodyEditor').default);


// rating
Vue.component('rating', require('./ratings/Rating').default);
