<template>
    <div id="teaEvaBundle">
        <div v-if="!showstudentlist">
            <!-- 查询的课程 -->
            <div class="select_join">
                <select v-model="selectcourse" id="select_term" @change="getcourse">
                    <option value="-1" selected>请先选择课程名称</option>
                    <option v-for="(course,index) in courseList" :value="course.Cid">{{course.Cname}}</option>
                </select>
            </div>
            <!-- 上传文件表单 -->
            <form enctype="multipart/form-data" novalidate>
                <div class="dropbox" :class="{notallowed: isallowed}">
                    <input type="file" :name="uploadFieldName" :disabled="isallowed"
                           @change="filesChange($event.target.name, $event.target.files);"
                           accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                           class="input-file">
                    <p>
                        点击此处上传文件
                        <br/> 或将文件拖至此处上传
                        <br/> 请上传Excel文件
                    </p>
                </div>
            </form>
        </div>
        <!-- 进行主观评价 -->
        <button class="subjectiveeva" v-show="teacherType === 'teacher'" v-if="!showstudentlist" @click="dosubjectiveeva" :disabled="!showfileuploadbutton"
                :class="{'disable':!showfileuploadbutton}">进行主观评价
        </button>

        <!-- 展示学生主观评价列表 -->
        <div v-if="showstudentlist" class="studentList">
            <ul>
                <li>
                    <span>学生姓名</span>
                    <span>学号</span>
                    <span>课程名称</span>
                    <div class='rating'>
                        <span style="width: 100%;margin-left: -50%;">主观成绩</span>
                    </div>
                </li>
                <li>
                    <span>张三</span>
                    <span>100002</span>
                    <span>网络原理</span>
                    <div class='rating'>
                        <rating :rating="4"></rating>
                    </div>
                </li>
                <li>
                    <span>张三</span>
                    <span>100002</span>
                    <span>网络原理</span>
                    <div class='rating'>
                        <rating :rating="4"></rating>
                    </div>
                </li>
                <li>
                    <span>张三</span>
                    <span>100002</span>
                    <span>网络原理</span>
                    <div class='rating'>
                        <rating :rating="4"></rating>
                    </div>
                </li>
                <li>
                    <span>张三</span>
                    <span>100002</span>
                    <span>网络原理</span>
                    <div class='rating'>
                        <rating :rating="4"></rating>
                    </div>
                </li>
                <li>
                    <span>张三</span>
                    <span>100002</span>
                    <span>网络原理</span>
                    <div class='rating'>
                        <rating :rating="4"></rating>
                    </div>
                </li>
                <li>
                    <span>张三</span>
                    <span>100002</span>
                    <span>网络原理</span>
                    <div class='rating'>
                        <rating :rating="4"></rating>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import * as teacherService from '../../service/teacherServce';
    import * as config from '../../config';
    import fileupload from '../../service/fileupload';
    export default {
        data() {
            return {
                userId: config.USER_ID, // 教师教职工ID
                courseList: [], // 该教师课程列表
                teacherType: '', // 教师类型
                uploadcounts: 0, // 上传成功的数量
                uploadFieldName: 'file',
                uploadTarget: '', // 文件上传的目标
                selectcourse: -1, // 进行主观评价时所选择的课程
                isallowed: true,
                showfileupload: true, // 是否显示上传文件区域
                showfileuploadbutton: false, // 是否显示学生主观评价列表
                showstudentlist: false, // 是否显示学生主观评价列表
                studentSubjectiveLists: [] // 主观评价时的学生列表
            }
        },
        methods: {
            getcourse() {
                console.log(this.selectcourse);
                this.isallowed = false;
            },
            changeuploadtarget(target) {
                this.uploadTarget = target;
                console.log(this.uploadTarget);
                this.isallowed = false;
            },
            /**
             * 批量添加，上传Excel
             * @param fieldName
             * @param fileList
             */
            filesChange(fieldName, fileList) {
                console.log(fieldName, fileList);
                let month = new Date().getMonth();
                let term = [8, 9, 10, 11, 0, 1].includes(month) ? 1 : 2;
                fileupload('teacherupload', fieldName, fileList, {
                    role: this.teacherType,
                    term: term
                })
                    .then(response => {
                        let res = response.data;
                        if (res.success) {
                            this.showfileuploadbutton = true;
                            this.uploadcounts = res.item; // 保存返回的上传成功的文件数
                        } else {
                            toastr.error('网络错误，请重试');
                        }
                    })
                    .catch(err => {
                        throw err;
                    });

            },
            // 进行主观评价
            dosubjectiveeva() {
                teacherService.subjectiveStudent(this.selectcourse,this.userId)
                    .then(response => {
                        let res = response.data;
                        if(res.success){
                            this.showstudentlist = true;
                            console.log('dosubjectiveeva');
                            this.studentSubjectiveLists = res.courselist;
                            console.log(this.studentSubjectiveLists);
                        }
                    })
                    .catch(err => {
                        throw err;
                    });
            }
        },
        created: function () {
//            获取当前教师的角色
            teacherService.getRole(this.userId)
                .then(response => {
                    let res = response.data;
                    if (res.success) {
                        this.teacherType = res.role;
                        console.log(this.teacherType);
                    } else {
                        toastr.error('网络错误，请重试！');
                    }
                })
                .catch(err => {
                    throw err;
                });
//            获取当前教师的课程列表
            teacherService.teacherCourseLsts(this.userId)
                .then(response => {
                    let res = response.data;
                    if (res.success) {
                        this.courseList = res.courselist;
                        console.log(this.courseList);
                    } else {
                        toastr.error('网络错误，请重试！');
                    }
                })
                .catch(err => {
                    throw err;
                });
        }
    }
</script>

<style lang="scss" scoped>
    #teaEvaBundle {
        margin-top: 50px;
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

        .dropbox {
            outline: 2px dashed grey;
            /* the dash box */
            outline-offset: -10px;
            background: lightcyan;
            color: dimgray;
            padding: 10px 10px;
            min-height: 200px;
            margin-top: 10px;
            /* minimum height */
            position: relative;
            cursor: pointer;
            &.notallowed {
                background: #dddddd;
                cursor: not-allowed;
                &:hover {
                    background: #dddddd;
                }
                .input-file {
                    cursor: not-allowed;
                }
            }
            .input-file {
                opacity: 0;
                /* invisible but it's there! */
                width: 100%;
                height: 200px;
                position: absolute;
                cursor: pointer;
            }

            &:hover {
                background: lightblue;
                /* when mouse over to the drop zone, change color */
            }

            p {
                font-size: 1.2em;
                text-align: center;
                padding: 50px 0;
            }
        }

        .subjectiveeva {
            margin-top: 10px;
            outline: none;
            background: #4285F4;
            width: 99.5%;
            border: 0;
            border-radius: 4px;
            padding: 12px 20px;
            color: #FFFFFF;
            font-family: inherit;
            font-size: inherit;
            font-weight: 500;
            line-height: inherit;
            text-transform: uppercase;
            cursor: pointer;
            &.disable {
                background: #ccc;
                cursor: not-allowed;
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
                        width: 23%;
                    }
                    div {
                        display: inline-block;
                        width: 25%;
                    }
                }
            }
        }
    }
</style>