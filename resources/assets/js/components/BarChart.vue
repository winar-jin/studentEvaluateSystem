<template>
        <bar-chart :options="options" :chartData="chartData" :width="clientWidth" :height="450"></bar-chart>
</template>

<script>
import { VueCharts, mixins } from 'vue-chartjs';
Vue.component('bar-chart', {
    data() {
        return {
        }
    },
    mixins: [mixins.reactiveProp],
    props: ['chartData','options'],
    extends: VueCharts.Bar,
    mounted() {
        this.renderChart(this.chartData, this.options)
    }
});

export default {
    data() {
        return {
        }
    },
    props: {
        'clientWidth': {
            default: 450,
            type: Number
        },
        'classmatesName': {
            type: Array
        },
        'classmatesScore': {
            type: Array
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