<template>
    <div id="TeaProfileUpdate">
        <p>请修改您的个人信息</p>
        <div width="100%">
            <form>
                <div class="form-group">
                    <label for="username">教师姓名</label>
                    <input type="text" ref="username" v-model="teacherInfo.Tname" :value="teacherInfo.Tname"
                           :disabled="isallowupdate" id="username" name="username" required="required"/>
                    <div class="pencil" @click="changeupdatestate('username')">
                        <icon name="pencil-square-o"></icon>
                    </div>
                </div>
                <div class="form-group idCant">
                    <label for="userid">教职工号</label>
                    <input class="" type="text" ref="userid" v-model="teacherInfo.Tid" :value="teacherInfo.Tid"
                           disabled="true" id="userid" name="userid" required="required"/>
                </div>
                <div class="form-group">
                    <label for="usersex">性别</label>
                    <input type="text" ref="usersex" v-model="teacherInfo.Tsex" :value="teacherInfo.Tsex"
                           :disabled="isallowupdate" id="usersex" name="usersex" required="required"/>
                    <div class="pencil" @click="changeupdatestate('usersex')">
                        <icon name="pencil-square-o"></icon>
                    </div>
                </div>
                <div class="form-group idCant">
                    <label for="apartment">所属学院</label>
                    <input type="text" v-model="teacherInfo.Tapartment" :value="teacherInfo.Tapartment" ref="apartment"
                           disabled="true" id="apartment" name="apartment" required="required"/>
                </div>
                <div class="form-group">
                    <label for="grade">联系方式</label>
                    <input type="text" v-model="teacherInfo.Tphone" :value="teacherInfo.Tphone" ref="grade"
                           :disabled="isallowupdate" id="grade" name="grade" required="required"/>
                    <div class="pencil" @click="changeupdatestate('grade')">
                        <icon name="pencil-square-o"></icon>
                    </div>
                </div>
                <div class="form-group">
                    <button type="button" @click="singleupdate">更新</button>
                </div>

            </form>
        </div>
    </div>
</template>

<script>
    import * as commonService from '../../service/commonService';
    import * as config from '../../config';
    import * as teacherService from '../../service/teacherServce';
    export default{
        data () {
            return {
                userId: config.USER_ID,
                userRole: config.USER_ROLE,
                isallowupdate: true, // 是否允许更改信息
                teacherInfo: {}, // 教师的个人信息
            }
        },
        methods: {
            singleupdate(){
                console.log(this.teacherInfo);
                teacherService.updateTeacherProfile(this.teacherInfo)
                    .then(response => {
                        let res = response.data;
                        if (res.success) {
                            swal({
                                    title: "更新成功!",
                                    text: "你已经成功更新教师的信息!",
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonText: "知道了",
                                    closeOnConfirm: false
                                },
                                function () {
                                    location.reload();
                                });
                        } else {
                            toastr.error('网络错误，请重试');
                        }
                    })
                    .catch(err => {
                        throw err;
                    });
            },
            // 改变当前input框的可编辑状态
            changeupdatestate(type){
                for (let item in this.$refs) {
                    this.$refs[item].disabled = true;
                    if (item === type) {
                        this.$refs[type].disabled = false;
                        this.$refs[type].focus();
                    }
                }
            }
        },
        created: function () {
            commonService.profile(this.userRole, this.userId)
                .then(response => {
                    let res = response.data;
                    if (res.success) {
                        this.teacherInfo = res.profile;
                        console.log(this.teacherInfo);
                    } else {
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

    #TeaProfileUpdate {
        .idCant{
            :hover{
                cursor: not-allowed;
            }
        }
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
                &:nth-child(5) {
                    display: inline-block !important;
                    width: 99.5% !important;
                }
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