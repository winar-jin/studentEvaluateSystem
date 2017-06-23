<template>
    <div id="userdelete">
        <b-tabs>
            <b-tab title="单个删除用户" active>
                <div class="singledelete">
                    <p v-if="isallowed">请先选择待删除的用户类型</p>
                    <p v-else>请先查询该用户的信息</p>
                    <form action="#" class="uploadcheck">
                        <p @click="changedaletetarget('teacher')" style="display:inline;margin-right:30px;">
                            <input name="upload" type="radio" id="teacher" :checked="deleteTarget==='teacher'"/>
                            <label for="teacher">删除单个教师信息</label>
                        </p>
                        <p @click="changedaletetarget('student')" style="display:inline;">
                            <input name="upload" type="radio" id="student" :checked="deleteTarget==='student'"/>
                            <label for="student">删除单个学生信息</label>
                        </p>
                    </form>
                    <div class="searchTarget">
                        <form v-on:submit.prevent="showProfile" class="search" :class="{notallowed: isallowed}">
                            <input v-model="deleteId" class="searchTerm" :disabled="isallowed"
                                   :placeholder="deleteTarget==='teacher'?'请输入教职工号':'请输入学号'"/>
                            <input class="searchButton" type="button" @click="showProfile"/>
                        </form>
                    </div>
                    <div class="searchresult" v-if="!hasresult">
                        <table width="100%" v-if="deleteTarget==='teacher'">
                            <thead>
                            <tr>
                                <th>教师姓名</th>
                                <th>教职工号</th>
                                <th>所属学院</th>
                                <th>联系方式</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{teacherInfo.name}}</td>
                                <td>{{teacherInfo.id}}</td>
                                <td>{{teacherInfo.apartment}}</td>
                                <td>{{teacherInfo.phone}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <table width="100%" v-else>
                            <thead>
                            <tr>
                                <th>学生姓名</th>
                                <th>学号</th>
                                <th>学院</th>
                                <th>年级</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{studentInfo.name}}</td>
                                <td>{{studentInfo.id}}</td>
                                <td>{{studentInfo.apartment}}</td>
                                <td>{{studentInfo.grade}}</td>
                            </tr>
                            </tbody>
                        </table>
                        <button class="singeldelbutton" @click="singledelete" :disabled="isallowed">删除</button>
                    </div>
                </div>
            </b-tab>
            <b-tab title="批量删除毕业生信息">
                <div class="graduate">
                    <p>点击确定按钮删除毕业生信息：</p>
                    <button @click="deletegraduate">删除</button>
                </div>
            </b-tab>
        </b-tabs>
    </div>
</template>

<script>
    import * as adminService from '../../service/adminService';
    export default {
        data() {
            return {
                deleteTarget: '', // 待删除的目标角色
                deleteId: '', // 待删除的目标ID
                isallowed: true, // 是否允许删除用户信息
                hasresult: true, // 是否显示搜索的结果
                studentInfo: {}, // 获取到的学生信息
                teacherInfo: {}, // 获取到的教师信息
            }
        },
        methods: {
            // 删除毕业生信息
            deletegraduate() {
                swal({
                        title: '确认删除毕业生信息么？',
                        text: '删除后将无法找回毕业生信息',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "确定删除!",
                        cancelButtonText: '取消',
                        closeOnConfirm: false
                    },
                    function () {
                        adminService.deleteGraduate()
                            .then(response => {
                                let res = response.data;
                                if (res.success) {
                                    swal("已删除!", "毕业生信息已删除.", "success");
                                } else {
                                    toastr.error('网络错误，请重试');
                                }
                            })
                            .catch(err => {
                                throw err;
                            });
                    });
            },

            // 获取到查询的用户信息
            showProfile(){
                this.hasresult = true;
                adminService.searchInfo(this.deleteTarget, this.deleteId)
                    .then(response => {
                        let res = response.data;
                        if (res.success) {
                            let profile = res.profile;
                            this.hasresult = false;
                            if (this.deleteTarget === 'student') {
                                this.studentInfo.name = profile.Sname;
                                this.studentInfo.apartment = profile.Sapartment;
                                this.studentInfo.grade = profile.Sgrade;
                                this.studentInfo.id = profile.Sid;
                            } else if (this.deleteTarget === 'teacher') {
                                this.teacherInfo.name = profile.Tname;
                                this.teacherInfo.apartment = profile.Tapartment;
                                this.teacherInfo.phone = profile.Tphone;
                                this.teacherInfo.id = profile.Tid;
                            }
                        } else {
                            toastr.error('查无此人，请查正后再次查询');
                        }
                    })
                    .catch(err => {
                        throw err
                    });
            },

            // 删除单个用户信息
            singledelete() {
                swal({
                        title: '确认删除该用户信息么？',
                        text: '删除后将无法找回该用户的信息',
                        type: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#DD6B55",
                        confirmButtonText: "确定删除!",
                        cancelButtonText: '取消',
                        closeOnConfirm: false
                    },
                    () => {
                        // TODO 单个删除的接口不通
                        if (this.deleteTarget === 'student') {
                            adminService.deleteUser('student', this.studentInfo.id)
                                .then(response => {
                                    let res = response.data;
                                    if(res.success){
                                        swal("已删除!", "该用户信息已删除.", "success");
                                    }else {
                                        toastr.error('网络错误，请重试');
                                    }
                                })
                                .catch(err => {
                                    throw err;
                                });
                        } else if(this.deleteTarget === 'teacher') {
                            adminService.deleteUser('teacher', this.teacherInfo.id)
                                .then(response => {
                                    let res = response.data;
                                    if(res.success){
                                        swal("已删除!", "该用户信息已删除.", "success");
                                    }else {
                                        toastr.error('网络错误，请重试');
                                    }
                                })
                                .catch(err => {
                                    throw err;
                                });
                        }
                    });
            },

            // 改变单个删除的用户目标
            changedaletetarget(target) {
                this.deleteTarget = target;
                console.log(this.deleteTarget);
                this.isallowed = false;
                this.hasresult = true;
            }
        }
    }
</script>
<style scoped>
    @import url(http://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css);
</style>
<style scoped lang="scss">
    #userdelete {
        // radio的所有样式
        .uploadcheck {
            /* Base for label styling */
            [type="radio"]:not(:checked),
            [type="radio"]:checked {
                position: absolute;
                left: -9999px;
            }
            [type="radio"]:not(:checked) + label,
            [type="radio"]:checked + label {
                position: relative;
                padding-left: 1.95em;
                cursor: pointer;
            }

            /* radio aspect */
            [type="radio"]:not(:checked) + label:before,
            [type="radio"]:checked + label:before {
                content: '';
                position: absolute;
                left: 0;
                top: 0;
                width: 1.25em;
                height: 1.25em;
                border: 2px solid #ccc;
                background: #fff;
                border-radius: 4px;
                box-shadow: inset 0 1px 3px rgba(0, 0, 0, .1);
            }
            /* checked mark aspect */
            [type="radio"]:not(:checked) + label:after,
            [type="radio"]:checked + label:after {
                content: '✔';
                position: absolute;
                top: .1em;
                left: .3em;
                font-size: 1.3em;
                line-height: 0.8;
                color: #09ad7e;
                transition: all .2s;
            }
            /* checked mark aspect changes */
            [type="radio"]:not(:checked) + label:after {
                opacity: 0;
                transform: scale(0);
            }
            [type="radio"]:checked + label:after {
                opacity: 1;
                transform: scale(1);
            }
            /* disabled radio */
            [type="radio"]:disabled:not(:checked) + label:before,
            [type="radio"]:disabled:checked + label:before {
                box-shadow: none;
                border-color: #bbb;
                background-color: #ddd;
            }
            [type="radio"]:disabled:checked + label:after {
                color: #999;
            }
            [type="radio"]:disabled + label {
                color: #aaa;
            }
            /* accessibility */
            [type="radio"]:checked:focus + label:before,
            [type="radio"]:not(:checked):focus + label:before {
                border: 2px dotted blue;
            }

            /* hover style just for information */
            label:hover:before {
                border: 2px solid #4778d9 !important;
            }
            /* Useless styles, just for demo design */
            body {
                font-family: "Open sans", "Segoe UI", "Segoe WP", Helvetica, Arial, sans-serif;
                color: #777;
            }
            h1,
            h2 {
                margin-bottom: .25em;
                font-weight: normal;
                text-align: center;
            }
            h2 {
                margin: .25em 0 2em;
                color: #aaa;
            }
            form {
                width: 100%;
                margin: 0 auto;
                margin-top: 10px;
            }
            .txtcenter {
                margin-top: 4em;
                font-size: .9em;
                text-align: center;
                color: #aaa;
            }
            .copy {
                margin-top: 2em;
            }
            .copy a {
                text-decoration: none;
                color: #4778d9;
            }
        }
        .searchresult {
            & table,
            th,
            td {
                border: 2px solid #ccc;
                text-align: center;
                font-size: 1.3em;
                line-height: 2.5;
                margin: 10px 0;
            }
        }
        margin-top: 50px;
        .singeldelbutton {
            margin: 10px auto;
            display: block;
            width: 90%;
            color: white;
            line-height: 2;
            font-size: 2em;
            background: hsl(351, 63%, 50%);
            border-radius: 5px;
            box-shadow: 0 0 5px #eee;
            &:hover {
                background: hsl(351, 63%, 40%)
            }
        }
        .searchTarget {
            margin-top: 10px;
        }
        .search {
            width: 100%;
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
        .singledelete {
            p {
                margin-top: 5px;
            }
        }
        .graduate {
            p {
                font-size: 1.5em;
                line-height: 1.5;
                margin: 15px 0;
            }
            button {
                width: 90%;
                color: white;
                margin: 0 auto;
                line-height: 2;
                font-size: 2em;
                background: hsl(351, 63%, 50%);
                border-radius: 5px;
                box-shadow: 0 0 5px #eee;
                &:hover {
                    background: hsl(351, 63%, 40%)
                }
            }
        }
    }
</style>