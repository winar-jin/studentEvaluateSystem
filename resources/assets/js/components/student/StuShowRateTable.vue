<template>
    <div id="stushowratetable">
        <b-tabs>
            <b-tab title="雷达图" active>
                <div class="radar-chart" ref="radarChart">
                    <radar :chartData="RadarchartData" :options="Radaroptions" :clientWidth="radarChartWidth"></radar>
                </div>
            </b-tab>
            <b-tab title="柱状图">
                <div class="bar-chart" ref="barChart">
                    <bar :chartData="BarchartData" :options="Baroptions" :classmatesName="classmatesName"
                         :classmatesScore="classmatesScore" :clientWidth="barChartWidth"></bar>
                </div>
            </b-tab>
            <b-tab title="折线图">
                <div class="line-chart" ref="lineChart">
                    <lines :chartData="LinechartData" :options="Lineoptions" :clientWidth="lineChartWidth"></lines>
                </div>
            </b-tab>
        </b-tabs>
    </div>
</template>

<script>
    import * as studentService from '../../service/studentService';
    import * as config from '../../config';
    export default {
        data() {
            return {
                userId: config.USER_ID, // 用户ID
                userRole: config.USER_ROLE, // 用户角色
                radarChartWidth: 450,
                barChartWidth: 450,
                lineChartWidth: 450,
                // 柱状图所需数据
                classmatesName: [],
                classmatesScore: [],
                totalTerm: 0, // 学期
                BarchartData: {},
                RadarchartData: {},
                LinechartData: {},
                Radaroptions: {
                    responsive: false,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                },
                Baroptions: {
                    responsive: false,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            barPercentage: 1
                        }],
                        yAxes: [{
                            stacked: true,
                            display: true,
                            ticks: {
                                min: 0,
                                max: 5,
                                step: 1,
                                beginAtZero: true // minimum value will be 0.
                            }
                        }]
                    },
                    animation: {
                        duration: 500,
                        easing: "easeOutQuart",
                        onComplete: function () {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = this.chart.config.options.defaultFontColor;
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            this.data.datasets.forEach(function (dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                        scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
                                    ctx.fillStyle = 'rgba(123,165,122,1)';
                                    var y_pos = model.y - 5;
                                    // Make sure data value does not get overflown and hidden
                                    // when the bar's value is too close to max value of scale
                                    // Note: The y value is reverse, it counts from top down
                                    if ((scale_max - model.y) / scale_max >= 0.93)
                                        y_pos = model.y + 20;
                                    ctx.fillText(`${dataset.data[i]}分`, model.x, y_pos);
                                }
                            });
                        }
                    }
                },
                Lineoptions: {
                    responsive: false,
                    maintainAspectRatio: false,
                    legend: {
                        display: false
                    },
                    scales: {
                        xAxes: [{
                            barPercentage: 1
                        }],
                        yAxes: [{
                            stacked: true,
                            display: true,
                            ticks: {
                                min: 0,
                                max: 5,
                                step: 1,
                                beginAtZero: true // minimum value will be 0.
                            }
                        }]
                    },animation: {
                        duration: 0,
                        onComplete: function () {
                            var ctx = this.chart.ctx;
                            ctx.font = Chart.helpers.fontString(Chart.defaults.global.defaultFontSize, 'normal', Chart.defaults.global.defaultFontFamily);
                            ctx.fillStyle = this.chart.config.options.defaultFontColor;
                            ctx.textAlign = 'center';
                            ctx.textBaseline = 'bottom';
                            this.data.datasets.forEach(function (dataset) {
                                for (var i = 0; i < dataset.data.length; i++) {
                                    var model = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._model,
                                        scale_max = dataset._meta[Object.keys(dataset._meta)[0]].data[i]._yScale.maxHeight;
                                    ctx.fillStyle = 'rgba(123,165,122,1)';
                                    var y_pos = model.y - 5;
                                    // Make sure data value does not get overflown and hidden
                                    // when the bar's value is too close to max value of scale
                                    // Note: The y value is reverse, it counts from top down
                                    if ((scale_max - model.y) / scale_max >= 0.93)
                                        y_pos = model.y + 20;
                                    ctx.fillText(`${dataset.data[i]}分`, model.x, y_pos);
                                }
                            });
                        }
                    }
                }
            }
        },
        methods: {},
        computed: {},
        created: function () {
            // 获取雷达图数据
            studentService.getAllTerm(this.userId, value => {
                this.totalTerm = value;
                studentService.getAllScore(this.userId, this.totalTerm)
                    .then(response => {
                        let res = response.data;
                        if (res.success) {
                            let allScore = res.summary;
                            let templeScore = [allScore.Mcourse, allScore.Mclassmates, allScore.Mlawpolicy, allScore.Mpe, allScore.Mactivity];
                            this.RadarchartData = {
                                labels: ['课程成绩', '同学互评', '道德法律', '体育成绩', '课外活动'],
                                datasets: [
                                    {
                                        label: '本学期表现',
                                        backgroundColor: 'rgba(123,165,122,0.4)',
                                        data: templeScore,
                                        borderWidth: 2
                                    }
                                ]
                            };
                        } else {
                            toastr.error('网络错误，请重试！');
                        }
                        console.log('radarData', this.RadarchartData)
                    })
                    .catch(err => {
                        throw err;
                    });

//                获取折线图数据
                studentService.getAllScore(this.userId, 0)
                    .then(response => {
                        let res = response.data;
                        if (res.success) {
                            let allScore = res.summary;
                            let templeScore = [];
                            for (let index = 0; index < this.totalTerm; index++) {
                                templeScore.push(allScore[index].Mscore.toFixed(2));
                                console.log(allScore[index].Mscore.toFixed(2));
                            }
                            console.log(templeScore,'templeScore折线图');
                            this.LinechartData = {
                                labels: ['第一学期', '第二学期', '第三学期', '第四学期', '第五学期', '第六学期', '第七学期'],
                                datasets: [
                                    {
                                        label: '本学期表现',
                                        backgroundColor: 'rgba(123,165,122,0.6)',
                                        data: templeScore,
                                        borderWidth: 2
                                    }
                                ]
                            };
                        } else {
                            toastr.error('网络错误，请重试！');
                        }
                    })
                    .catch(err => {
                        throw err;
                    });
//                获取柱状图数据
                studentService.getClassmatesScore(this.userId, this.totalTerm)
                    .then(response => {
                        let res = response.data;
                        if (res.success) {
                            let classmatesScore = res.classmates;
                            for (let item in classmatesScore) {
                                this.classmatesName[item] = classmatesScore[item].Sname;
                                // console.log(this.classmatesName,item,'循环里name',this);
                                this.classmatesScore[item] = classmatesScore[item].Mscore.toFixed(2);
                                // console.log(this.classmatesScore,item,'循环里score',this);
                            }
                            this.BarchartData = {
                                labels: this.classmatesName,
                                datasets: [{
                                    label: '本学期表现',
                                    backgroundColor: 'rgba(123,165,122,0.6)',
                                    data: this.classmatesScore,
                                    // data: [3, 1, 2, 3.5, 2, 4],
                                    borderWidth: 2
                                }]
                            };
                        } else {
                            toastr.error('网络错误，请重试！');
                        }
                    })
                    .catch(err => {
                        throw err;
                    });
            });
        }
    }
</script>

<style lang="scss" scoped>
    #stushowratetable {
        margin-top: 50px;
        .radar-chart {
            padding: 8%;
        }
        .bar-chart {
            padding: 10%;
        }
        .line-chart {
            padding: 10%;
        }
    }
</style>