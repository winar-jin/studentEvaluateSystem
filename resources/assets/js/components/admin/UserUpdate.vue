<template>
    <div>
        <div class="userupdate">
            <p v-if="isallowed">请先选择欲更新的用户类型</p>
            <p v-else>请先查询该用户的信息</p>

            <!-- radio 选择更新的目标 -->
            <form action="#" class="uploadcheck">
                <p @click="changedaletetarget('teacher')" style="display:inline;margin-right:30px;">
                    <input name="upload" type="radio" id="teacher" :checked="updateTarget==='teacher'"/>
                    <label for="teacher">更新教师信息</label>
                </p>
                <p @click="changedaletetarget('student')" style="display:inline;">
                    <input name="upload" type="radio" id="student" :checked="updateTarget==='student'"/>
                    <label for="student">更新学生信息</label>
                </p>
            </form>

            <!-- 搜索框 -->
            <div class="searchTarget">
                <form v-on:submit.prevent="showProfile" class="search" :class="{notallowed: isallowed}">
                    <input v-model="updateId" class="searchTerm" :disabled="isallowed"
                           :placeholder="updateTarget==='teacher'?'请输入教职工号':'请输入学号'"/>
                    <input class="searchButton" @click="showProfile" type="button"/>
                </form>
            </div>

            <!-- 搜索结果 -->
            <div class="searchresult" v-if="!hasresult">
                <div width="100%" v-if="updateTarget==='teacher'">
                    <form>
                        <div class="form-group">
                            <label for="username">教师姓名</label>
                            <input type="text" id="username" name="username" :value="teacherInfo.name"
                                   v-model="teacherInfo.name" required="required"/>
                        </div>
                        <div class="form-group">
                            <label for="userid">教职工号</label>
                            <input class="donotedited" type="text" id="userid" name="userid" :value="teacherInfo.id"
                                   disabled/>
                        </div>
                        <div class="form-group">
                            <label for="usersex">性别</label>
                            <input type="text" id="usersex" name="usersex" :value="teacherInfo.sex"
                                   v-model="teacherInfo.sex" required="required"/>
                        </div>
                        <div class="form-group">
                            <label for="apartment">所属学院</label>
                            <input type="text" id="apartment" name="apartment" :value="teacherInfo.apartment"
                                   v-model="teacherInfo.apartment" required="required"/>
                        </div>
                        <div class="form-group" style="display:block;width:100%;">
                            <label for="phone">联系方式</label>
                            <input type="text" id="phone" name="phone" :value="teacherInfo.phone"
                                   v-model="teacherInfo.phone" required="required"/>
                        </div>
                        <div class="form-group">
                            <button type="button" @click="singleupdate">更新</button>
                        </div>
                    </form>
                </div>
                <div width="100%" v-else>
                    <form>
                        <div class="form-group">
                            <label for="username">学生姓名</label>
                            <input type="text" id="username" name="username" :value="studentInfo.name"
                                   v-model="studentInfo.name" required="required"/>
                        </div>
                        <div class="form-group">
                            <label for="userid">学号</label>
                            <input class="donotedited" type="text" id="userid" name="userid" :value="studentInfo.id"
                                   disabled/>
                        </div>
                        <div class="form-group">
                            <label for="usersex">性别</label>
                            <input type="text" id="usersex" name="usersex" :value="studentInfo.sex"
                                   v-model="studentInfo.sex" required="required"/>
                        </div>
                        <div class="form-group">
                            <label for="apartment">学院</label>
                            <input type="text" id="apartment" name="apartment" :value="studentInfo.apartment"
                                   v-model="studentInfo.apartment" required="required"/>
                        </div>
                        <div class="form-group">
                            <label for="grade">年级</label>
                            <input type="text" id="grade" name="grade" :value="studentInfo.grade"
                                   v-model="studentInfo.grade" required="required"/>
                        </div>
                        <div class="form-group">
                            <label for="class">班级</label>
                            <input type="text" id="class" name="class" :value="studentInfo.class"
                                   v-model="studentInfo.class" required="required"/>
                        </div>
                        <div class="form-group">
                            <button type="button" @click="singleupdate">更新</button>
                        </div>
                    </form>
                </div>
                <!--<button class="singeldelbutton" @click="singleupdate" :disabled="isallowed">更新</button>-->
            </div>
        </div>
    </div>
</template>

<script>
    import * as adminService from '../../service/adminService';
    export default {
        data() {
            return {
                isallowed: true, // 确认是否允许用户修改信息
                updateTarget: '', // 欲更新的用户目标
                updateId: '', // 欲更新的用户ID
                studentInfo: {}, // 学生的信息
                teacherInfo: {}, // 教师的信息
                hasresult: true, // 当用户搜索后才显示结果
            }
        },
        methods: {
            // 获取到查询的用户信息
            showProfile(){
                this.hasresult = true;
                adminService.searchInfo(this.updateTarget, this.updateId)
                    .then(response => {
                        let res = response.data;
                        if (res.success) {
                            let profile = res.profile;
                            this.hasresult = false;
                            if (this.updateTarget === 'student') {
                                this.studentInfo.name = profile.Sname;
                                this.studentInfo.apartment = profile.Sapartment;
                                this.studentInfo.grade = profile.Sgrade;
                                this.studentInfo.sex = profile.Ssex;
                                this.studentInfo.id = profile.Sid;
                                this.studentInfo.class = profile.Sclass;
                            } else if (this.updateTarget === 'teacher') {
                                this.teacherInfo.name = profile.Tname;
                                this.teacherInfo.apartment = profile.Tapartment;
                                this.teacherInfo.phone = profile.Tphone;
                                this.teacherInfo.id = profile.Tid;
                                this.teacherInfo.sex = profile.Tsex;
                            }
                        } else {
                            toastr.error('查无此人，请查正后再次查询');
                        }
                    })
                    .catch(err => {
                        throw err
                    });
            },

            // 改变欲更新的用户目标
            changedaletetarget(target) {
                this.updateTarget = target;
                console.log(this.updateTarget);
                this.isallowed = false;
                this.hasresult = true;
            },

            // 更新用户信息
            singleupdate() {
                if (this.updateTarget === 'teacher') {
                    adminService.updateTeacher(this.teacherInfo)
                        .then(response => {
                            if (response.data.success) {
                                swal('修改成功！','教师信息已修改成功！','success');
                            } else {
                                toastr.error('网络错误，请重新提交。')
                            }
                        })
                        .catch(err => {
                            throw err;
                        });
                } else if (this.updateTarget === 'student') {
                    adminService.updateStudent(this.studentInfo)
                        .then(response => {
                            if (response.data.success) {
                                swal('修改成功！','学生信息已修改成功！','success');
                            } else {
                                toastr.error('网络错误，请重新提交。')
                            }
                        })
                        .catch(err => {
                            throw err;
                        });
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    $max-width: 600px;
    $max-height: 400px;
    $gutters: 24px; // Colors
    $black: #000000;
    $dark-gray: rgba($black, 0.8);
    $gray: rgba($black, 0.6);
    $light-gray: rgba($black, 0.4);
    $lighter-gray: rgba($black, 0.2);
    $white: #FFFFFF;
    $accent: #4285F4; // Font Weights
    $thin: 100;
    $light: 300;
    $regular: 400;
    $semibold: 500;
    $bold: 700;
    $ultra: 800;
    .donotedited {
        &:hover {
            cursor: not-allowed;
        }
    }

    .userupdate {
        margin-top: 50px;

        .searchresult {

            // 表单的所有样式
            form {
                z-index: 15;
                position: relative;
                background: #fff;
                width: 100%;
                border-radius: 4px; // box-shadow: 0 0 10px rgba($black, .1);
                box-sizing: border-box;
                margin: 20px auto 10px;
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
        // 大按钮的样式
        .singeldelbutton {
            margin: 10px auto;
            display: block;
            width: 90%;
            color: white;
            line-height: 2;
            font-size: 2em;
            background: hsl(151, 49%, 50%);
            border-radius: 5px;
            box-shadow: 0 0 5px #eee;
            &:hover {
                background: hsl(151, 49%, 40%)
            }
        }
        // 搜索的所有样式
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
    }
</style>