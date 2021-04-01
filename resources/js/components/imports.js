// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

const components = {
    // news
    'news-list':              'News/NewsList',
    'news-body-editor':       'News/Form/NewsBodyEditor',
    'news-date-editor':       'News/Form/NewsDateEditor',

    // articles
    'articles-article':       'Articles/Article',
    'articles-list':          'Articles/Lists/ArticlesList',
    'articles-top-tags-list': 'Articles/Lists/PopularArticleTagsList',
    'articles-body-editor':   'Articles/Form/ArticleBodyEditor',
    'articles-tags-editor':   'Articles/Form/ArticleTagsEditor',
    'articles-date-editor':   'Articles/Form/ArticleDateEditor',
    'articles-search':        'Articles/ArticlesSearch',

    // events

    // rating
    'rating':                 'Ratings/Rating',
}

for (const [name, path] of Object.entries(components)) {
    Vue.component(name, require('./' + path).default);
}
