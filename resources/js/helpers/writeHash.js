module.exports = function () {
    let args = Array.prototype.slice.call(arguments);

    history.pushState(
        {},
        null,
        this.$route.path + '#' + encodeURIComponent(args.shift())
    )
};
