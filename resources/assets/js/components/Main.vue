<template>
    <div>
        <appheader>
        </appheader>
        <b-modal ref="updateheadimg" id="updateheadimg" :hide-header="true" :hide-footer="true">
            <!-- 修改头像和密码 -->
            <b-tabs>
                <b-tab title="修改头像">
                    <div class="form-group">
                        <label for="headimg_bgimg">请选择图像上传头像：</label>
                        <form enctype="multipart/form-data" novalidate>
                            <input class="bgimgupload__original" ref="bgimgupload"
                                   @change="filesChange($event.target.name, $event.target.files);" type="file"
                                   id="headimg_bgimg" name="file" accept="image/*"/>
                        </form>
                    </div>
                    <div class="showImg">
                        <img :src="uploadFieldName" alt="">
                    </div>
                    <div class="controlPanel">
                        <button @click="cancelupdateavatar">取消更新</button>
                        <button @click="updateavatar">更新头像</button>
                    </div>
                    
                </b-tab>
                <b-tab title="修改密码">
                    <div class="form-group editpassword">
                        <form novalidate>
                            <label for="oldpassword">旧密码：</label>
                            <input v-model="password.old" type="password" id="oldpassword">
                            <label for="newpassword">新密码：</label>
                            <input v-model="password.new" type="password" id="newpassword">
                            <label for="renewpassword">再次输入新密码：</label>
                            <input v-model="password.renew" type="password" id="renewpassword">
                        </form>
                    </div>
                    <button @click="changePassword">更改密码</button>
                </b-tab>
            </b-tabs>
        </b-modal>
        <div class="container">
            <div class="row" v-if="user_role=='teacher'">
                <div class="col-md-3">
                    <teachernavbar @changeComponent="changecompnent"></teachernavbar>
                </div>
                <div class="col-md-9">
                    <subindex v-if="currentCompontent === 'subindex'"></subindex>
                    <teacher-bundleeva v-else-if="currentCompontent === 'teacher-bundleeva'"></teacher-bundleeva>
                    <teacher-profileupdate v-else-if="currentCompontent === 'teacher-profileupdate'"></teacher-profileupdate>
                    <teacher-showrating v-else-if="currentCompontent === 'teacher-showrating'"></teacher-showrating>
                    <teacher-updateeva v-else-if="currentCompontent === 'teacher-updateeva'"></teacher-updateeva>
                </div>
            </div>
            <div class="row" v-if="user_role=='student'">
                <div class="col-md-3">
                    <studentnavbar @changeComponent="changecompnent"></studentnavbar>
                </div>
                <div class="col-md-9">
                    <subindex v-if="currentCompontent === 'subindex'"></subindex>
                    <student-evaeachother v-else-if="currentCompontent === 'student-evaeachother'"></student-evaeachother>
                    <student-profileupdate v-else-if="currentCompontent === 'student-profileupdate'"></student-profileupdate>
                    <student-showratelist v-else-if="currentCompontent === 'student-showratelist'"></student-showratelist>
                    <student-showratetable v-else-if="currentCompontent === 'student-showratetable'"></student-showratetable>
                </div>
            </div>
            <div class="row" v-if="user_role=='admin'">
                <div class="col-md-3">
                    <adminnavbar @changeComponent="changecompnent"></adminnavbar>
                </div>
                <div class="col-md-9">
                    <subindex v-if="currentCompontent === 'subindex'"></subindex>
                    <admin-useradd v-else-if="currentCompontent === 'admin-useradd'"></admin-useradd>
                    <admin-userdelete v-else-if="currentCompontent === 'admin-userdelete'"></admin-userdelete>
                    <admin-userupdate v-else-if="currentCompontent === 'admin-userupdate'"></admin-userupdate>
                    <admin-bulletin v-else-if="currentCompontent === 'admin-bulletin'"></admin-bulletin>
                    <admin-checkeva v-else-if="currentCompontent === 'admin-checkeva'"></admin-checkeva>
                    <admin-profile-update v-else-if="currentCompontent === 'admin-profile'"></admin-profile-update>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as config from '../config';
import fileupload from '../service/fileupload';
import * as commonService from '../service/commonService';
import error_alert from '../service/swalConfig';
export default {
    data() {
        return {
            rating: 2,
            currentCompontent: 'subindex', // 应该显示的当前的组件
            user_role: config.USER_ROLE, // 当前用户的角色
            user_id: config.USER_ID, // 当前用户的ID
            uploadFieldName: 'imags/default.jpeg', // 用户上传的头像
            password: {}, // 用户需要更改的密码
        }
    },
    methods: {
        changecompnent(data,title) {
            this.currentCompontent = data;
            document.title = title + ' | 教师评学系统';
        },
        // 用户上传头像
        filesChange(targetName, files) {
                 console.log(targetName, files);
                fileupload('uploadavatar', targetName, files, {
                    role: this.user_role,
                    id: this.user_id
                }).then(response => {
                    let res = response.data;
                    console.log(res);
                    console.log(res.item);
                    if (res.success) {
                        this.uploadFieldName = res.avatarPath;
                    } else {
                        toastr.error('上传失败，请重新上传');
                    }
                }).catch(err => {
                    this.uploadError = err.response;
                });
            },
            // 取消更新头像
            cancelupdateavatar(){
                console.log('cancel');
                this.$refs.updateheadimg.hide();
            },
            // 更新头像
            updateavatar(){
                console.log('upload');
                // this.uploadFieldName = 'imags/3.jpg';
                commonService.updateavatar(this.uploadFieldName,this.user_role,this.user_id)
                .then(response => {
                    let res = response.data;
                    if(res.success){
                        swal({
                                    title: "更新成功!",
                                    text: "您已经成功更新头像!",
                                    type: "success",
                                    showCancelButton: false,
                                    confirmButtonText: "知道了",
                                    closeOnConfirm: false
                                },
                                function () {
                                    location.reload();
                                });
                    }else{
                        toastr.error('网络错误，请重试');
                    }
                })
                .catch(err => {
                    throw err;
                });
            },
            // 更改密码
            changePassword(){
                if(!this.password.new || !this.password.renew || !this.password.old){
                    error_alert('输入为空','请重新输入');
                    this.password= {};
                }else{
                    this.password.old = hex_md5(this.password.old);
                    this.password.new = hex_md5(this.password.new);
                    this.password.renew = hex_md5(this.password.renew);
                    console.log(this.password);
                    if(this.password.new !== this.password.renew){
                        error_alert('两次输入密码不同','请重新输入');
                        this.password= {};
                    } else{
                        commonService.changePass(this.password,this.user_role,this.user_id)
                    .then(response => {
                        let res = response.data;
                        if(res.success){
                            swal("更改成功!", "您已经成功更改密码!", "success");
                            this.$refs.updateheadimg.hide();
                        }else{
                            if(res.msg === 'password wrong'){
                                error_alert('原密码错误','请重新输入');
                                this.password = {};
                            } else{
                                toastr.error('网络错误，请重试！');
                            }
                        }
                    })
                    .catch(err => {
                        throw err;
                    });
                    }
                }
            }
    },
    created: function () {
        if (!this.user_role) {
            window.location.replace('/bishe/version1.0/public');
        }
        axios.post('getheaderinfo', {
            role: this.user_role,
            id: this.user_id
        })
            .then(response => {
                let res = response.data;
                // console.log(res);
                // 当登录成功后，将用户的角色和用户ID存入cookie
                if (res.success === true) {
                    if(res.headerinfo.photoPath){
                        this.uploadFieldName = res.headerinfo.photoPath;
                    } else{
                        this.avatarImg = 'imags/default.jpeg';
                    }                   
                }
            })
            .catch(err => {
                throw err;
            });
    }
}
</script>

<style lang="scss" scoped>
.controlPanel{
    width: 100%;
    margin-top: 30px;
    text-align: center;
    button{
        margin: 20px 4%;
        display:inline-block;
    }
}

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
    .showImg {
        text-align: center;
        border: none !important;
        outline: none !important;
        img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            box-shadow: 0 0 5px #eee;
        }
    }

    .editpassword {
        label {
            margin-top: 10px;
        }
    }

    .form-group {
        margin-top: 10px;
    }

    button {
        outline: none;
        background: $accent;
        width: 40%;
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
        margin: 15px auto;
        text-align: center;
        display: block;

        .two & {
            background: $white;
            color: $accent;
        }
    }

    input {
        outline: none !important;
        display: block;
        background: rgba($black, 0.1);
        width: 100%;
        border: 0 !important;
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
</style>

