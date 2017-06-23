<template>
    <div class="profileupdate" width="100%">
        <p>请修改您的个人信息：</p>
        <form>
            <div class="form-group">
                <label for="username">教师姓名</label>
                <input type="text" ref="username" :value="username" :disabled="isallowupdate" id="username"
                       name="username" v-model="username"
                       required="required"/>
                <div class="pencil" @click="changeupdatestate('username')">
                    <icon name="pencil-square-o"></icon>
                </div>
            </div>
            <div class="form-group">
                <label for="userid">教职工号</label>
                <input type="text" ref="userid" disabled :value="userid" id="userid" name="userid" v-model="userid"
                       required="required"/>
            </div>
            <div class="form-group">
                <label for="usersex">性别</label>
                <input type="text" ref="usersex" :disabled="isallowupdate" :value="usersex" id="usersex" name="usersex"
                       v-model="usersex"
                       required="required"/>
                <div class="pencil" @click="changeupdatestate('usersex')">
                    <icon name="pencil-square-o"></icon>
                </div>
            </div>
            <div class="form-group">
                <label for="telphone">联系方式</label>
                <input type="text" ref="telphone" :disabled="isallowupdate" :value="userphone" id="telphone"
                       name="telphone" v-model="userphone"
                       required="required"/>
                <div class="pencil" @click="changeupdatestate('telphone')">
                    <icon name="pencil-square-o"></icon>
                </div>
            </div>
            <div class="form-group">
                <button type="button" @click="singleupdate">更新</button>
            </div>

        </form>
    </div>
</template>

<script>
    import * as commonService from '../../service/commonService';
    import * as adminService from '../../service/adminService';
    export default {
        data() {
            return {
                isallowupdate: true, // 是否允许更改信息
                // 获取用户的ID
                userid: this.$cookie.get('userid__main') || localStorage.getItem('userid__main'),
                // 获取用户的角色（admin，student，teacher）
                userrole: this.$cookie.get('role__main') || localStorage.getItem('role__main'),
                username: '', // 姓名
                usersex: '', // 性别
                userphone: '', // 电话
            }
        },
        created: function () {
            // 请求数据，初始化管理员信息，准备被修改
            commonService.profile(this.userrole, this.userid)
                .then(response => {
                    let res = response.data;
                    if (res.success) {
                        this.username = res.profile.Aname;
                        this.usersex = res.profile.Asex;
                        this.userphone = res.profile.Aphone;
                    } else {
                        toastr.error('网络出现错误，请刷新后重试!');
                    }
                })
                .catch(err => {
                    throw err;
                });
        },
        methods: {
            // 提交管理员信息更新
            singleupdate() {
                adminService.updateAdminProfie(this.userid, this.username, this.usersex, this.userphone)
                    .then(() => {
                        swal('更新成功！', '您已经成功更新管理员信息!', 'success');
                    })
                    .catch(err => {
                        throw err;
                    });
            },
            // 改变当前input框的可编辑状态
            changeupdatestate(type) {
                for (let item in this.$refs) {
                    this.$refs[item].disabled = true;
                    if (item === type) {
                        this.$refs[type].disabled = false;
                        this.$refs[type].focus();
                    }
                }
            }
        }
    }
</script>

<style scoped lang="scss">
    .profileupdate {
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