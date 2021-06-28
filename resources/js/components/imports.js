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
    'points-rating':            'Ratings/PointsRating',
    'travels-rating':           'Ratings/TravelsRating',
    'articles-rating':          'Ratings/ArticlesRating',

    // statistics
    'rating-points-statistics': 'Statistics/RatingPointsStatistics',
    'articles-statistics':      'Statistics/ArticlesStatistics',
    'events-statistics':        'Statistics/EventsStatistics',

    'rating-points-compare':    'Statistics/Compare/RatingPointsCompare',

    // admin
    'admin-users-datatable':    'Admin/UsersDatatable'
}

for (const [name, path] of Object.entries(components)) {
    Vue.component(name, require('./' + path).default);
}
