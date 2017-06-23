<template>
    <div id="teaUpdateEva">
        <!-- 搜索框 -->
        <div class="searchTarget">
            <form v-on:submit.prevent="showstuList" class="search" :class="{notallowed: !allowsearchflag}">
                <input v-model="studentidTobeSearch" class="searchTerm" placeholder="请输入学号"/>
                <div class="select_join">
                    <select v-model="selectcourse" id="select_term" @change="allowsearch">
                        <option value="-1" selected>请先选择课程</option>
                        <option v-for="course in teacherCourseList" :value="course.Cname">{{course.Cname}}</option>
                    </select>
                </div>
                <input class="searchButton" type="button" @click="showstuList" :disabled="!allowsearchflag"/>
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
                <li v-if="searchedInfo !== null">
                    <span>{{searchedInfo.Sname}}</span>
                    <span>{{searchedInfo.Sid}}</span>
                    <span>{{searchedInfo.Cname}}</span>
                    <div class='rating'>
                        <rating @returnvalue="setSubjectScore" :rating="searchedInfo.score_subjective"></rating>
                    </div>
                    <div class='rating'>
                        <rating @returnvalue="setObjectScore" :rating="searchedInfo.score_objective"></rating>
                    </div>
                </li>
                <li @click="updateComment" class="updateButton" v-if="searchedInfo !== null" style="text-align:center">
                    更新
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    // TODO 更新的时候，要怎样提交，一个一个点或是，同时提交两个主观和客观
    import * as teacherService from '../../service/teacherServce';
    import * as config from '../../config';
    import error_alert from '../../service/swalConfig';
    export default {
        data() {
            return {
                userId: config.USER_ID, // 教师ID
                allowsearchflag: false, // 是否允许搜索
                isallowed: false, // 是否搜索成功，显示搜索结果
                selectcourse: -1,
                teacherCourseList: [], // 教师的课程列表
                studentidTobeSearch: '', // 待查找的学号
                searchedInfo: null, // 用学号查询到的学生信息，带成绩的
                allowUpdateFlag: false // 是否允许更新评价
            }
        },
        methods: {
            allowsearch(){
                this.allowsearchflag = true;
                this.allowUpdateFlag = true;
            },
            // 设置更改的主观成绩
            setSubjectScore(newscore){
                this.searchedInfo.score_subjective = newscore;
                console.log(newscore);
            },
            // 设置更改后的客观成绩
            setObjectScore(newscore){
                this.searchedInfo.score_objective = newscore;
                console.log(newscore);
            },
            // 展示按学号和课程的搜索结果
            showstuList($event) {
                if(!this.allowUpdateFlag){
                    error_alert('查询失败','请先选择课程！');
                }else{
                     this.isallowed = true;
                console.log(this.selectcourse);
                console.log(this.searchedInfo);
                teacherService.teachersearch(this.studentidTobeSearch,this.selectcourse)
                    .then(response => {
                        let res = response.data;
                        if(res.success){
                            this.searchedInfo = res.profile;
                            if(this.searchedInfo === null){
                                toastr.error('该学生未选择该课程');
                            }
                            console.log(this.searchedInfo);
                        }else{
                            toastr.error('网络错误，请重试');
                        }
                    })
                    .catch(err => {
                        throw err;
                    });
                }
            },
            // 修改评价
            updateComment(){
                console.log('update');
                teacherService.updateComment(
                    this.studentidTobeSearch,
                    this.searchedInfo.score_objective,
                    this.searchedInfo.score_subjective,
                    this.selectcourse)
                .then(response => {
                    let res = response.data;
                    if(res.success){
                        swal('修改成功','你已成功修改学生评价','success');
                    }else{
                        toastr.error('网络错误，请稍后重试');
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
                        this.teacherCourseList = res.courselist;
                        console.log(this.teacherCourseList);
                    }else{
                        toastr.error('网络错误，请重试');
                    }
                })
                .catch(err => {
                    throw err;
                });
        }
    }
</script>


<style lang="scss" scoped>
    #teaUpdateEva {
        margin-top: 50px;
        option{
            background:rgba(9, 173, 126, 0.8);
            color: white;
        }
        .updateButton{
            line-height: 3em !important;
            font-size: 1.2em;
            &:hover{
                cursor:pointer;
            }
        }
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
            border-top: 5px solid #09ad7e;
            border-bottom: 5px solid #09ad7e;
            box-sizing: border-box;
            right: 40px;
            position: absolute;
            background-color: rgba(9, 173, 126, .8);
            width: 25%;
            height: 40px;
            overflow: hidden;
            -webkit-border-radius: 4px;
            line-height: 40px;
            padding-left: 10px;
            top: 0px;
            select {
                background: transparent;
                display: -webkit-box;
                width: 97%;
                font-size: 7pt;
                color: white;
                border: 0;
                border-radius: 0;
                height: 28px;
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
                        background: #09ad7e;
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