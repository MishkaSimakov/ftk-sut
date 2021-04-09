let routes = window.Laravel.routes

module.exports = function () {
    let args = Array.prototype.slice.call(arguments);

    let name = args.shift();
    if (routes[name] === undefined) {
        console.error('Route not found ', name);
    } else {
        let url = `/${routes[name]
            .split('/')
            .map(s => {
                if (s[0] === '{') {
                    s = s.slice(-2, -1) === '?' ? s.substring(1, s.length - 2) : s.substring(1, s.length - 1)

                    let arg = args[0][s]
                    delete args[0][s]

                    return arg
                }

                return s
            })
            .join('/')}`

        let query = ''
        if (args[0]) {
            query = Object.entries(args[0]).map(([key, arg]) => key + '=' + arg).join('&')
        }

        return url + (query.length !== 0 ? '?' + query : '');
    }
};
