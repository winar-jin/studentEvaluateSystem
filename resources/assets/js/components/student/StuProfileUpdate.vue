<template>
    <div id="stuProfileUpdate">
        <p>您的个人信息如下：</p>
        <div width="100%">
            <!--<form>
                        <div class="form-group">
                            <label for="username">学生姓名</label>
                            <input type="text" ref="username" value="张三" :disabled="isallowupdate" id="username" name="username" required="required" />
                            <div class="pencil" @click="changeupdatestate('username')">
                                <icon name="pencil-square-o"></icon>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="userid">学号</label>
                            <input type="text" ref="userid" :disabled="isallowupdate" id="userid" name="userid" required="required" />
                            <div class="pencil" @click="changeupdatestate('userid')">
                                <icon name="pencil-square-o"></icon>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="usersex">性别</label>
                            <input type="text" ref="usersex" :disabled="isallowupdate" id="usersex" name="usersex" required="required" />
                            <div class="pencil" @click="changeupdatestate('usersex')">
                                <icon name="pencil-square-o"></icon>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="apartment">学院</label>
                            <input type="text" ref="apartment" :disabled="isallowupdate" id="apartment" name="apartment" required="required" />
                            <div class="pencil" @click="changeupdatestate('apartment')">
                                <icon name="pencil-square-o"></icon>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="grade">年级</label>
                            <input type="text" ref="grade" :disabled="isallowupdate" id="grade" name="grade" required="required" />
                            <div class="pencil" @click="changeupdatestate('grade')">
                                <icon name="pencil-square-o"></icon>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="class">班级</label>
                            <input type="text" ref="class" :disabled="isallowupdate" id="class" name="class" required="required" />
                            <div class="pencil" @click="changeupdatestate('class')">
                                <icon name="pencil-square-o"></icon>
                            </div>
                        </div>
                        <div class="form-group">
                            <button type="button" @click="singleupdate">更新</button>
                        </div>
                    </form>-->
            <form>
                <div class="form-group">
                    <label for="username">学生姓名</label>
                    <input type="text" :disabled="isallowupdate" :value="stuProfile.Sname" id="username" name="username" required="required"/>
                </div>
                <div class="form-group">
                    <label for="userid">学号</label>
                    <input type="text" :disabled="isallowupdate" :value="stuProfile.Sid" id="userid" name="userid" required="required"/>
                </div>
                <div class="form-group">
                    <label for="usersex">性别</label>
                    <input type="text" :disabled="isallowupdate" :value="stuProfile.Ssex" id="usersex" name="usersex" required="required"/>
                </div>
                <div class="form-group">
                    <label for="apartment">学院</label>
                    <input type="text" :disabled="isallowupdate" :value="stuProfile.Sapartment" id="apartment" name="apartment" required="required"/>
                </div>
                <div class="form-group">
                    <label for="grade">年级</label>
                    <input type="text" :disabled="isallowupdate" :value="stuProfile.Sgrade" id="grade" name="grade" required="required"/>
                </div>
                <div class="form-group">
                    <label for="class">班级</label>
                    <input type="text" :disabled="isallowupdate" :value="stuProfile.Sclass" id="class" name="class" required="required"/>
                </div>

            </form>
        </div>
    </div>
</template>

<script>
    import * as commonService from '../../service/commonService';
    import * as config from '../../config';
    export default {
        data() {
            return {
                userId: config.USER_ID,
                userRole: config.USER_ROLE,
                isallowupdate: true, // 是否允许更改信息
                stuProfile: {} // 获取到的学生信息
            }
        },
        methods: {
        },
        created: function () {
            commonService.searchInfo(this.userRole, this.userId)
                .then(response => {
                    let res = response.data;
                    if (res.success) {
                        this.stuProfile = res.profile;
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
    #stuProfileUpdate {
        margin-top: 50px; // 表单的所有样式
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
                position: relative;
                .pencil {
                    position: absolute;
                    right: 10px;
                    top: 55%;
                    z-index: 9999;
                    &:hover {
                        cursor: pointer;
                    }
                }
                &:nth-child(2n) {
                    display: inline-block;
                    width: 50%;
                }
                &:nth-child(2n+1) {
                    display: inline-block;
                    width: 49%;
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
                    width: 99.5%;
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
</style>