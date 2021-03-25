// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// news
Vue.component('news-list', require('./news/NewsList').default);
Vue.component('news-body-editor', require('./News/Form/NewsBodyEditor').default);


// articles
Vue.component('articles-list', require('./articles/Lists/ArticlesList').default);
Vue.component('articles-top-tags-list', require('./articles/Lists/PopularArticleTagsList').default);
Vue.component('articles-body-editor', require('./Articles/Form/ArticleBodyEditor').default);
Vue.component('articles-tags-editor', require('./Articles/Form/ArticleTagsEditor').default);
Vue.component('articles-date-editor', require('./Articles/Form/ArticleDateEditor').default);
Vue.component('articles-search', require('./Articles/ArticlesSearch').default);


// rating
Vue.component('rating', require('./ratings/Rating').default);
