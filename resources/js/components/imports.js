// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const components = {
    // news
    'news-body-editor':         'News/Form/NewsBodyEditor',
    'news-date-editor':         'News/Form/NewsDateEditor',

    // articles
    'articles-body-editor':     'Articles/Form/ArticleBodyEditor',
    'articles-tags-editor':     'Articles/Form/ArticleTagsEditor',
    'articles-date-editor':     'Articles/Form/ArticleDateEditor',
    'articles-search':          'Articles/ArticlesSearch',

    // events

    // rating
    'rating':                   'Ratings/Rating',

    // statistics
    'rating-points-statistics':  'Statistics/RatingPointsStatistics'
}

for (const [name, path] of Object.entries(components)) {
    Vue.component(name, require('./' + path).default);
}
