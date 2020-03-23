import api from '../api/rating'
import { GoogleCharts } from 'google-charts'

const state = {
    loading: true,
    rating: null,
    chartData: null
};

const getters = {
    rating: state => {
        return state.rating
    },
    loading: state => {
        return state.loading
    }
};

const actions = {
    getRating({dispatch, commit}, id) {
        commit('setRatingLoading', true);

        api.getRating(id).then((response) => {
            console.log(response);
            commit('setRating', response.data);
            commit('setRatingLoading', false);
        })
    },
    loadChart({dispatch, commit}) {
        GoogleCharts.load('current', {packages: ['corechart']}).then(() => {
            dispatch('prepareData');
        });
    },
    prepareData({dispatch, commit}) {
        // Define the chart to be drawn.
        var data = new GoogleCharts.api.visualization.DataTable();

        data.addColumn('string', 'Element');
        data.addColumn('number', 'Percentage');
        data.addRows([
            ['Nitrogen', 0.78],
            ['Oxygen', 0.21],
            ['Other', 0.01]
        ]);

        commit('setChartData', data);
    },
    drawChart({dispatch, commit}, container) {
        var chart = new GoogleCharts.api.visualization.PieChart(container);
        chart.draw(state.chartData, null);
    }
};

const mutations = {
    setRating(state, rating) {
        state.rating = rating
    },
    setRatingLoading(state, status) {
        state.loading = status
    },
    setChartData(state, data) {
        state.chartData = data
    }
};

export default {
    state,
    getters,
    mutations,
    actions
}
