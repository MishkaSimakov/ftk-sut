(window["webpackJsonp"] = window["webpackJsonp"] || []).push([[0],{

/***/ "./node_modules/simple-datatables/src/date.js":
/*!****************************************************!*\
  !*** ./node_modules/simple-datatables/src/date.js ***!
  \****************************************************/
/*! exports provided: parseDate */
/***/ (function(module, __webpack_exports__, __webpack_require__) {

"use strict";
__webpack_require__.r(__webpack_exports__);
/* harmony export (binding) */ __webpack_require__.d(__webpack_exports__, "parseDate", function() { return parseDate; });
/* harmony import */ var dayjs__WEBPACK_IMPORTED_MODULE_0__ = __webpack_require__(/*! dayjs */ "./node_modules/dayjs/dayjs.min.js");
/* harmony import */ var dayjs__WEBPACK_IMPORTED_MODULE_0___default = /*#__PURE__*/__webpack_require__.n(dayjs__WEBPACK_IMPORTED_MODULE_0__);
/* harmony import */ var dayjs_plugin_customParseFormat__WEBPACK_IMPORTED_MODULE_1__ = __webpack_require__(/*! dayjs/plugin/customParseFormat */ "./node_modules/dayjs/plugin/customParseFormat.js");
/* harmony import */ var dayjs_plugin_customParseFormat__WEBPACK_IMPORTED_MODULE_1___default = /*#__PURE__*/__webpack_require__.n(dayjs_plugin_customParseFormat__WEBPACK_IMPORTED_MODULE_1__);



dayjs__WEBPACK_IMPORTED_MODULE_0___default.a.extend(dayjs_plugin_customParseFormat__WEBPACK_IMPORTED_MODULE_1___default.a)

/**
 * Use dayjs to parse cell contents for sorting
 * @param  {String} content     The datetime string to parse
 * @param  {String} format      The format for dayjs to use
 * @return {String|Boolean}     Datatime string or false
 */
const parseDate = (content, format) => {
    let date = false

    // Converting to YYYYMMDD ensures we can accurately sort the column numerically

    if (format) {
        switch (format) {
        case "ISO_8601":
            // ISO8601 is already lexiographically sorted, so we can just sort it as a string.
            date = content
            break
        case "RFC_2822":
            date = dayjs__WEBPACK_IMPORTED_MODULE_0___default()(content, "ddd, MM MMM YYYY HH:mm:ss ZZ").format("YYYYMMDD")
            break
        case "MYSQL":
            date = dayjs__WEBPACK_IMPORTED_MODULE_0___default()(content, "YYYY-MM-DD hh:mm:ss").format("YYYYMMDD")
            break
        case "UNIX":
            date = dayjs__WEBPACK_IMPORTED_MODULE_0___default()(content).unix()
            break
        // User defined format using the data-format attribute or columns[n].format option
        default:
            date = dayjs__WEBPACK_IMPORTED_MODULE_0___default()(content, format).format("YYYYMMDD")
            break
        }
    }

    return date
}


/***/ })

}]);