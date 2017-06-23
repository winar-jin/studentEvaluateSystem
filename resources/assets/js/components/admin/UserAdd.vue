<template>
    <div id="useradd">
        <b-tabs>
            <b-tab title="批量添加用户" active>
                <p v-if="isallowed">请先选择您要上传的用户类型</p>
                <p v-else>请上传Excel表格文件</p>
                <form action="#" class="uploadcheck">
                    <p @click="changeuploadtarget('teacher')" style="display:inline;margin-right:30px;">
                        <input key="bundel1" name="upload" type="radio" id="teacher" :checked="uploadTarget==='teacher'"/>
                        <label for="teacher">上传<strong>教师</strong>文件</label>
                    </p>
                    <p @click="changeuploadtarget('student')" style="display:inline;">
                        <input key="bundel2" name="upload" type="radio" id="student" :checked="uploadTarget==='student'"/>
                        <label for="student">上传<strong>学生</strong>文件</label>
                    </p>
                </form>
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
            </b-tab>
            <b-tab title="单个添加用户">
                <p v-if="isallowed">请先选择添加的用户类型</p>
                <p v-else>请添加该用户的信息</p>
                <form action="#" class="uploadcheck">
                    <p @click="changeuploadtarget('teacher')" style="display:inline;margin-right:30px;">
                        <input key="single1" name="upload" type="radio" id="teacher" :checked="uploadTarget==='teacher'"/>
                        <label for="teacher">添加<strong>教师</strong>信息</label>
                    </p>
                    <p @click="changeuploadtarget('student')" style="display:inline;">
                        <input key="single2" name="upload" type="radio" id="student" :checked="uploadTarget==='student'"/>
                        <label for="student">添加<strong>学生</strong>信息</label>
                    </p>
                    <div class="singleupload">
                        <div v-if="uploadTarget==='teacher'">
                            <form key="teacherInfo">
                                <div class="form-group">
                                    <label for="username">教师姓名</label>
                                    <input type="text" id="username" name="username" v-model="teacherInfo.username"
                                           required="required"/>
                                </div>
                                <div class="form-group">
                                    <label for="userid">教职工号</label>
                                    <input type="text" id="userid" name="userid" v-model="teacherInfo.id"
                                           required="required"/>
                                </div>
                                <div class="form-group">
                                    <label for="usersex">性别</label>
                                    <input type="text" id="usersex" name="usersex" v-model="teacherInfo.sex"
                                           required="required"/>
                                </div>
                                <div class="form-group">
                                    <label for="apartment">所属学院</label>
                                    <input type="text" id="apartment" name="apartment" v-model="teacherInfo.apartment"
                                           required="required"/>
                                </div>
                                <div class="form-group" style="display:block;width:100%;">
                                    <label for="phone">联系方式</label>
                                    <input type="text" id="phone" name="phone" v-model="teacherInfo.phone"
                                           required="required"/>
                                </div>
                                <div class="form-group">
                                    <button type="button" @click="addsingleuser">提交</button>
                                </div>
                            </form>
                        </div>
                        <div v-if="uploadTarget==='student'">
                            <form key="studentInfo">
                                <div class="form-group">
                                    <label for="username">学生姓名</label>
                                    <input type="text" id="username" name="username" v-model="studentInfo.username"
                                           required="required"/>
                                </div>
                                <div class="form-group">
                                    <label for="userid">学号</label>
                                    <input type="text" id="userid" name="userid" v-model="studentInfo.id"
                                           required="required"/>
                                </div>
                                <div class="form-group">
                                    <label for="usersex">性别</label>
                                    <input type="text" id="usersex" name="usersex" v-model="studentInfo.sex"
                                           required="required"/>
                                </div>
                                <div class="form-group">
                                    <label for="apartment">学院</label>
                                    <input type="text" id="apartment" name="apartment" v-model="studentInfo.apartment"
                                           required="required"/>
                                </div>
                                <div class="form-group">
                                    <label for="grade">年级</label>
                                    <input type="text" id="grade" name="grade" v-model="studentInfo.grade"
                                           required="required"/>
                                </div>
                                <div class="form-group">
                                    <label for="class">班级</label>
                                    <input type="text" id="class" name="class" v-model="studentInfo.class"
                                           required="required"/>
                                </div>
                                <div class="form-group">
                                    <button type="button" @click="addsingleuser">提交</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </form>
            </b-tab>
        </b-tabs>

    </div>
</template>

<script>
    import axios from 'axios';
    import error_alert from '../../service/swalConfig';
    import * as adminService from '../../service/adminService';
    import fileupload from '../../service/fileupload';
    export default {
        data() {
            return {
                teacherInfo: {}, // 表单中添加的教师的信息
                studentInfo: {}, // 表单中的添加的学生的信息
                uploadcounts: 0, // 上传成功的数量
                uploadError: null, // 上传错误时的提示信息
                uploadFieldName: 'file', // 上传input标签的name属性
                uploadTarget: '', // 文件上传的目标,老师或是学生
                isallowed: true // 是否允许用户上传文件
            }
        },
        computed: {},
        methods: {
            // 添加单个用户
            addsingleuser(){
                let adduserInfo = {};
                if (this.uploadTarget === 'teacher') {
                    adduserInfo = this.teacherInfo;
                    console.log(this.teacherInfo);
                } else {
                    adduserInfo = this.studentInfo;
                    console.log(this.studentInfo);
                }
                adminService.addSingleUser(this.uploadTarget, adduserInfo)
                    .then(() => {
                        swal("添加成功!", `你已经成功添加了一个${this.uploadTarget === 'teacher' ? '教师' : '学生'}!`, "success");
                    })
                    .catch(err => {
                        throw err;
                    });
            },

            /**
             * 批量添加，上传Excel
             * @param fieldName -> 'file'
             * @param fileList -> 文件
             */
            filesChange(targetName, files) {
                fileupload('adminupload', targetName, files, {
                    target: this.uploadTarget
                })
                    .then(response => {
                        let res = response.data;
                        console.log(res);
                        console.log(res.item);
                        if (res.success) {
                            this.uploadcounts = parseInt(res.item);
                            swal("添加成功!", `你已经成功添加了${this.uploadcounts}个${this.uploadTarget === 'teacher' ? '教师' : '学生'}!`, "success");
                        } else {
                            toastr.error('上传失败，请重新上传');
                        }
                    }).catch(err => {
                    this.uploadError = err.response;
                });
            },

            // 改变当前变动的角色
            changeuploadtarget(target) {
                this.uploadTarget = target;
                console.log(this.uploadTarget);
                this.isallowed = false;
            }
        }
    }
</script>

<style scoped lang="scss">
    $max-width: 600px;
    $max-height: 400px;
    $gutters: 24px;

    // Colors
    $black: #000000;
    $dark-gray: rgba($black, 0.8);
    $gray: rgba($black, 0.6);
    $light-gray: rgba($black, 0.4);
    $lighter-gray: rgba($black, 0.2);
    $white: #FFFFFF;
    $accent: #4285F4;

    // Font Weights
    $thin: 100;
    $light: 300;
    $regular: 400;
    $semibold: 500;
    $bold: 700;
    $ultra: 800;
    #useradd {
        margin-top: 50px;
        p {
            margin: 10px 0;
        }
        .singleupload {
            form {
                z-index: 15;
                position: relative;
                background: #fff;
                width: 100%;
                border-radius: 4px; // box-shadow: 0 0 10px rgba($black, .1);
                box-sizing: border-box;
                margin: 100px auto 10px;
                overflow: hidden;
                .form-group {
                    display: flex;
                    flex-wrap: wrap;
                    justify-content: space-between;
                    margin: 0 0 20px;
                    &:nth-child(2n) {
                        display: inline-block;
                        width: 50%;
                    }
                    &:nth-child(2n+1) {
                        display: inline-block;
                        width: 49%;
                    }
                    &:last-child {
                        margin: 0;
                        display: block;
                        width: 100%;
                    }

                    label {
                        display: block;
                        margin: 0 0 10px;
                        color: $gray;
                        font-size: 12px;
                        font-weight: $semibold;
                        line-height: 1;
                        text-transform: uppercase;
                        letter-spacing: .2em;

                        .two & {
                            color: #fff;
                        }
                    }

                    input {
                        outline: none;
                        display: block;
                        background: rgba($black, 0.1);
                        width: 100%;
                        border: 0;
                        border-radius: 4px;
                        box-sizing: border-box;
                        padding: 12px 20px;
                        color: $gray;
                        font-family: inherit;
                        font-size: inherit;
                        font-weight: $semibold;
                        line-height: inherit;
                        transition: 0.3s ease;

                        &:focus {
                            color: $dark-gray;
                        }

                        .two & {
                            color: #fff;

                            &:focus {
                                color: #fff;
                            }
                        }
                    }
                    button {
                        outline: none;
                        background: $accent;
                        width: 100%;
                        border: 0;
                        border-radius: 4px;
                        padding: 12px 20px;
                        color: $white;
                        font-family: inherit;
                        font-size: inherit;
                        font-weight: $semibold;
                        line-height: inherit;
                        text-transform: uppercase;
                        cursor: pointer;

                        .two & {
                            background: $white;
                            color: $accent;
                        }
                    }
                }
            }
        }
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
        .dropbox {
            outline: 2px dashed grey;
            /* the dash box */
            outline-offset: -10px;
            background: lightcyan;
            color: dimgray;
            padding: 10px 10px;
            min-height: 200px;
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

        form {
            margin-top: 10px;
        }
    }
</style>