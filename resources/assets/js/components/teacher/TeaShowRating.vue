<template>
    <div id="teaShowRating">
        <b-tabs>
            <b-tab title="按课程查看" active>
                <!-- 查询的课程 -->
                <div class="select_join">
                    <select v-model="selectcourse" id="select_term" @change="getcourse">
                        <option value="-1" selected>请先选择所要查询的课程</option>
                        <option v-for="course in courseList" :value="course.Cid">{{course.Cname}}</option>
                    </select>
                </div>

                <div v-if="showByCname" class="studentList">
                    <ul>
                        <li>
                            <span>学生姓名</span>
                            <span>学号</span>
                            <div class='rating'>
                                <span style="width: 100%;margin-left: -50%;">主观成绩</span>
                            </div>
                            <div class='rating'>
                                <span style="width: 100%;margin-left: -50%;">客观成绩</span>
                            </div>
                        </li>
                        <li v-for="list in cnameList">
                            <span>{{list.Sname}}</span>
                            <span>{{list.Sid}}</span>
                            <div class='rating'>
                                <rating :rating="list.ScmarkSubjective" :readonly="true"></rating>
                            </div>
                            <div class='rating'>
                                <rating :rating="list.ScmarkObjective" :readonly="true"></rating>
                            </div>
                        </li>
                    </ul>
                </div>
            </b-tab>
            <b-tab title="按学号查看">
                <!-- 搜索框 -->
                <div class="searchTarget">
                    <form v-on:submit.prevent="getscoreByid" class="search">
                        <input class="searchTerm" v-model="sidTobeSearch" placeholder="请输入学号"/>
                        <input class="searchButton" type="button" @click="getscoreByid"/>
                    </form>
                </div>
                <div v-if="isallowed" class="studentList">
                    <ul>
                        <li>
                            <span>学生姓名</span>
                            <span>学号</span>
                            <span>课程名称</span>
                            <div class='rating'>
                                <span style="width: 100%;margin-left: -50%;">主观成绩</span>
                            </div>
                            <div class='rating'>
                                <span style="width: 100%;margin-left: -50%;">客观成绩</span>
                            </div>
                        </li>
                        <li v-for="list in scoreListById">
                            <span>{{list.Sname}}</span>
                            <span>{{sidTobeSearch}}</span>
                            <span>{{list.Cname}}</span>
                            <div class='rating'>
                                <rating :rating="list.ScmarkSubjective" :readonly="true"></rating>
                            </div>
                            <div class='rating'>
                                <rating :rating="list.ScmarkObjective" :readonly="true"></rating>
                            </div>
                        </li>

                    </ul>
                </div>
            </b-tab>
        </b-tabs>
    </div>
</template>

<script>
    import * as teacherService from '../../service/teacherServce';
    import * as config from '../../config';
    export default {
        beforeMount() {
            console.log('get all course');
        },
        data() {
            return {
                userId: config.USER_ID, // 用户ID
                selectcourse: -1, // 所要查询的课程
                isallowed: false, // 是否显示学号的查询结果
                showByCname: false, // 按课程名查找
                courseList: [], // 课程列表
                cnameList: [], // 按课程查出来的成绩列表
                scoreListById: [], // 按学号查出来的成绩列表
                sidTobeSearch: '', // 将要查询的学号
            }
        },
        methods: {
//            根据课程名获取学生的成绩
            getcourse($event) {
                this.showByCname = true;
                console.log(this.selectcourse);
                teacherService.getScoreByCname(this.selectcourse)
                    .then(response => {
                        let res = response.data;
                        if(res.success){
                            this.cnameList = res.scorelist;
                            console.log(this.cnameList);
                        }else{
                            toastr.error('网络错误，请重试');
                        }
                    })
                    .catch(err => {
                        throw err;
                    });
            },
            // 根据学号查询所有成绩
            getscoreByid(){
                this.isallowed = true;
                teacherService.getScoreBySid(this.sidTobeSearch)
                    .then(response => {
                        let res = response.data;
                        if(res.success){
                            this.scoreListById = res.scorelist;
                            console.log(this.scoreListById);
                        }else{
                            toastr.error('网络错误，请重试');
                        }
                    })
                    .catch(err => {
                        throw err;
                    });
            }
        },
        created: function () {
            teacherService.teacherCourseLsts(this.userId)
                .then(response => {
                    let res = response.data;
                    if(res.success){
                        this.courseList = res.courselist;
                        console.log(this.courseList);
                    }
                })
                .catch(err => {
                    throw err;
                });
        }
    }
</script>

<style lang="scss" scoped>
    #teaShowRating {
        margin-top: 50px;
        .studentList {
            border-radius: 2px;
            background: #eee;
            padding: 5px;
            margin-top: 10px; // 列表的样式
            ul {
                width: 100%;
                list-style: none;
                padding: 0;
                li {
                    line-height: 2.5;
                    background: rgba(153, 204, 255, .8);
                    text-align: center;
                    .rating {
                        padding-top: .5em;
                    }
                    &:nth-child(2n) {
                        background: rgba(119, 170, 255, .8);
                    }
                    &:last-child {
                        background: rgba(51, 102, 255, 0.8);
                    }
                    span {
                        display: inline-block;
                        width: 15%;
                    }
                    div {
                        display: inline-block;
                        width: 25%;
                    }
                }
            }
        }
        .select_join {
            margin-top: 10px;
            background-color: #ddd;
            width: 100%;
            height: 40px;
            overflow: hidden;
            border: #FEFEFE 2px solid;
            -webkit-border-radius: 4px;
            line-height: 40px;
            padding-left: 10px;
            border-radius: 4px; // -webkit-box-shadow: inset 0px 0px 10px 1px #FEFEFE;
            // box-shadow: inset 0px 0px 10px 1px #FEFEFE;
            select {
                background: transparent;
                width: 97%;
                font-size: 7pt;
                color: rgba(0, 0, 0, .6);
                border: 0;
                border-radius: 0;
                height: 28px; // -webkit-appearance: none;
                padding-right: 20px;
                &:focus {
                    outline: none;
                }
            }
        }
        .searchTarget {
            // 搜索的所有样式
            .search {
                width: 100%;
                margin: 20px 0 10px 0;
                position: relative;
                &.notallowed {
                    &:before {
                        background: #ccc;
                        cursor: not-allowed;
                    }
                    & .searchTerm {
                        border: 5px solid #ccc;
                        cursor: not-allowed;
                    }
                    & .searchButton {
                        cursor: not-allowed;
                    }
                }
                &:before {
                    position: absolute;
                    top: 0;
                    right: 0;
                    width: 40px;
                    height: 40px;
                    line-height: 40px;
                    font-family: 'FontAwesome';
                    content: '\f002';
                    background: #09ad7e;
                    text-align: center;
                    color: #fff;
                    border-radius: 1px;
                    -webkit-font-smoothing: subpixel-antialiased;
                    font-smooth: always;
                }
                .searchTerm {
                    box-sizing: border-box;
                    width: 100%;
                    border: 5px solid #09ad7e;
                    padding: 5px;
                    height: 40px;
                    border-radius: 1px;
                    outline: none;
                }
                .searchButton {
                    position: absolute;
                    top: 0;
                    right: 0;
                    width: 40px;
                    height: 40px;
                    opacity: 0;
                    cursor: pointer;
                }
            }
        }
    }
</style>