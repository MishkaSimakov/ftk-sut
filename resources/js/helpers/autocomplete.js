import algoliasearch from 'algoliasearch'
import autocomplete from 'autocomplete.js'

var index = algoliasearch('CDK0HXATF0', 'd550aa859ec7c412fe2c8f732d0e8daa');

 // for production
// var index = algoliasearch('4J119ZGKYQ', '50cada16d278e3d9789b6e6c3a6fed7a');

function newHitsSource(index, params) {
    return function doSearch(query, cb) {
        index
            .search(query, params)
            .then(function(res) {
                cb(res.hits, res);
            })
            .catch(function(err) {
                console.error(err);
                cb([]);
            });
    };
}

export const userautocomplete = selector => {
    var users = index.initIndex('users');

    return autocomplete(selector, {}, {
        source: newHitsSource(users, { hitsPerPage: 5 }),
        displayKey: 'name',
        templates: {
            suggestion(suggestion) {
                return '<span>' + suggestion.name + '</span>'
            },
            empty: '<div class="aa-empty">Нет таких людей!</div>'
        }
    })
};
