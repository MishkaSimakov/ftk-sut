import {_adapters, helpers} from 'chart.js'
import dayjs from 'dayjs'
import customParseFormat from 'dayjs/plugin/customParseFormat'
import isoWeek from 'dayjs/plugin/isoWeek'

dayjs.extend(customParseFormat)
dayjs.extend(isoWeek)

const FORMATS = {
    datetime: 'MMM D, YYYY, h:mm:ss a',
    millisecond: 'h:mm:ss.SSS a',
    second: 'h:mm:ss a',
    minute: 'h:mm a',
    hour: 'hA',
    day: 'MMM D',
    week: 'll',
    month: 'MMM YYYY',
    quarter: '[Q]Q - YYYY',
    year: 'YYYY',
}

_adapters._date.override({
    _id: 'dayjs', // DEBUG ONLY

    formats: function () {
        return FORMATS
    },

    parse: function (value, format) {
        if (value === null || value === undefined) return null
        if (typeof value === 'string' && typeof format === 'string') {
            value = dayjs(value, format)
        } else if (!(value instanceof dayjs)) {
            value = dayjs(value)
        }
        return value.isValid() ? value.valueOf() : null
    },

    format: function (time, format) {
        return dayjs(time).format(format)
    },

    add: function (time, amount, unit) {
        return dayjs(time).add(amount, unit).valueOf()
    },

    diff: function (max, min, unit) {
        return dayjs(max).diff(dayjs(min), unit)
    },

    startOf: function (time, unit, weekday) {
        if (unit === 'isoWeek') return dayjs(time).isoWeekday(weekday).valueOf()
        return dayjs(time).startOf(unit).valueOf()
    },

    endOf: function (time, unit) {
        return dayjs(time).endOf(unit).valueOf()
    },
})
