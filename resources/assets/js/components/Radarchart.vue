<template>
    <radar-chart :scaleStartValue="0" :options="options" :chartData="chartData" :width="clientWidth" :height="450"></radar-chart>
</template>

<script>
    import {VueCharts,mixins} from 'vue-chartjs';
    Vue.component('radar-chart', {
        extends: VueCharts.Radar,
        mixins: [mixins.reactiveProp],
        props: ['chartData','options'],
        mounted() {
            this.renderChart(this.chartData, this.options)
        }
    });

    export default{
        props: {
            'clientWidth': {
                default: 450,
                type: Number
            },
            'chartData': {
                type: Object
            },
            'options':{
                type: Object
            }
        },
    }
</script>