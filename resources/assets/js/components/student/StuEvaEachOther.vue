<template>
    <div id="stuEvaEachOther">
        <p>请对以下同学进行评价：</p>
        <div class="studentlist">
            <table>
                <thead>
                <tr>
                    <th>姓名</th>
                    <th>学号</th>
                    <th>评分</th>
                </tr>
                </thead>
                <tbody v-if="isallowed">
                <tr v-for="(item,index) in classmatesName">
                    <td>{{item}}</td>
                    <td>{{classmatesSid[index]}}</td>
                    <td style="text-align:center">
                        <rating :id="index" :size="ratSize" :increment=1 @returnvalue="getratingvalue"
                                @getEvaId="setEvaId" :rating="classmatesRate[index]"></rating>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
    import * as studentService from '../../service/studentService';
    import * as config from '../../config';
    export default {
        data() {
            return {
                userId: config.USER_ID,
                ratSize: 20,
                totalTerm: 0,
                names: ['qw', 'qwqw', 'qwe'],
                classmatesName: [], // 班上所有人的姓名
                classmatesSid: [], // 班上所有人的学号
                classmatesRate: [],
                isallowed: false,
                evaId: 0
            }
        },
        methods: {
            // 获取到分数后的处理函数
            getratingvalue(rating) {
                console.log(`您给出的分数为${rating}!!!`);
                this.classmatesRate[this.evaId] = rating;
                let templeId = this.classmatesSid[this.evaId];
                console.log(templeId,'templedId');
                console.log(this.classmatesRate[this.evaId],'classMatesRate');
                studentService.studentEva(templeId, this.classmatesRate[this.evaId], this.totalTerm)
                    .then(response => {
                        let res = response.data;
                        if (res.success) {
                            toastr.success('该同学已评价成功！');
                        } else {
                            toastr.error('网络错误，请重试！');
                        }
                    })
                    .catch(err => {
                        throw err;
                    });
            },
            setEvaId(evaId){
                console.log(evaId,'evaId');
                this.evaId = evaId;
            }
        },
        created: function () {
            studentService.getAllTerm(this.userId, value => {
                this.totalTerm = value;
                studentService.getClassmatesScore(this.userId, this.totalTerm)
                    .then(response => {
                        let res = response.data;
                        if (res.success) {
                            let classmatesScore = res.classmates;
                            for (let item in classmatesScore) {
                                this.classmatesName[item] = classmatesScore[item].Sname;
                                this.classmatesSid[item] = classmatesScore[item].Sid;
                            }
                            console.log(this.classmatesName, '循环里name');
                            console.log(this.classmatesSid, '循环里id');
                        } else {
                            toastr.error('网络错误，请重试！');
                        }
                        this.isallowed = true;
                    })
                    .catch(err => {
                        throw err;
                    });
            });
        },
    }
</script>

<style lang="scss" scoped>
    table {
        width: 100%;
    }

    table,
    tbody,
    thead,
    tr,
    td,
    th {
        border: 1px solid #ccc;
        text-align: center;
        line-height: 2.5;
    }

    #stuEvaEachOther {
        margin-top: 50px;
    }
</style>