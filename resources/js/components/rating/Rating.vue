<template>
<!--    <div v-if="loading" id="loader" class="d-flex mt-5 justify-content-center">-->
<!--        <div class="text-gray-600 spinner-border text-lg" role="status">-->
<!--            <span class="sr-only"></span>-->
<!--        </div>-->

<!--        <span class="text-gray-600 ml-3 my-auto h3">-->
<!--            <strong>Загрузка...</strong><br>-->
<!--        </span>-->
<!--    </div>-->

<!--    <div class="rating" v-else-if="rating.length">-->
        <vue-plotly :data="data" :layout="layout" :options="options"/>
<!--    </div>-->

<!--    <div v-else>Ничего нет!</div>-->
</template>

<script>
    import VuePlotly from '@statnett/vue-plotly'

    export default {
        components: {
            VuePlotly
        },
        data: function () {
            return {
                data: [
                    {
                        x: [20, 14, 23],
                        y: ['giraffes', 'orangutans', 'monkeys'],
                        name: 'SF Zoo',
                        orientation: 'h',
                        marker: {
                            color: 'rgba(55,128,191,0.6)',
                            width: 1
                        },
                        type: 'bar'
                    },
                    {
                        x: [12, 18, 29],
                        y: ['giraffes', 'orangutans', 'monkeys'],
                        name: 'LA Zoo',
                        orientation: 'h',
                        type: 'bar',
                        marker: {
                            color: 'rgba(255,153,51,0.6)',
                            width: 1
                        }
                    }
                ],
                layout: {
                    barmode: 'stack',
                    hovermode: false,
                },
                options: {
                    scrollZoom: false,
                    showLink: false,
                    modeBarButtonsToRemove: ['toImage', 'zoom2d', 'pan', 'pan2d', 'autoScale2d'],
                    // modeBarButtonsToAdd: [],
                    displayLogo: false,
                    displayModeBar: false,
                }
            }
        }
    }
</script>

<style scoped>

</style>
