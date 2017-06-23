<template>
    <div class="bulletin">
        <p>请填写以下信息以发布公告：</p>
        <p>请先选择公告的类型：</p>
        <form action="#" class="uploadcheck">
            <p @click="changeType('bulletin')" style="display:inline;margin-right:30px;">
                <input name="type" type="radio" id="bulletin" :checked="bulletinType==='bulletin'"/>
                <label for="bulletin">公告</label>
            </p>
            <p @click="changeType('school_news')" style="display:inline;margin-right:30px;">
                <input name="type" type="radio" id="school_news" :checked="bulletinType==='school_news'"/>
                <label for="school_news">校园新闻</label>
            </p>
            <p @click="changeType('apart_news')" style="display:inline;margin-right:30px;">
                <input name="type" type="radio" id="apart_news" :checked="bulletinType==='apart_news'"/>
                <label for="apart_news">院系新闻</label>
            </p>
        </form>
        <div class="bulletin__content" v-if="isallowed">
            <form>
                <div class="form-group">
                    <label for="bulletin_title">公告标题</label>
                    <input type="text" id="bulletin_title" name="bulletin_title" v-model="bulletinInfo.title"
                           required="required"/>
                </div>
                <div class="form-group">
                    <label for="bulletin_link">公告链接</label>
                    <input type="text" id="bulletin_link" name="bulletin_link" v-model="bulletinInfo.link"
                           required="required"/>
                </div>
                <div class="form-group">
                    <label for="bulletin_bgimg">公告背景图</label>
                    <form enctype="multipart/form-data" novalidate>
                        <input class="bgimgupload__original" ref="bgimgupload"
                               @change="filesChange($event.target.name, $event.target.files);" type="file"
                               id="bulletin_bgimg" name="file" accept="image/*"/>
                    </form>
                </div>
                <div class="form-group">
                    <button type="button" @click="cancelbulletin">取消</button>
                    <button type="button" @click="addbulletin">添加</button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import fileupload from '../../service/fileupload';
    import * as adminService from '../../service/adminService'
    export default {
        data() {
            return {
                target: 'bgphoto', // 上传的是公告的背景图片
                uploadError: '', // 若上传图片有错误的错误提示
                bulletinInfo: {}, // 公告的信息
                bulletinType: 0, // 公告的类型
                isallowed: false, // 选择类型后才能添加公告
                bgImagePath: null // 公告的背景图片
            }
        },
        computed: {
        },
        methods: {
            // 上传新闻背景图片
            filesChange(targetName, files) {
                 console.log(targetName, files);
                fileupload('adminupload', targetName, files, {
                    target: 'bgphoto'
                }).then(response => {
                    let res = response.data;
                    console.log(res);
                    console.log(res.item);
                    if (res.success) {
                        this.uploadcounts = parseInt(res.item);
                        // 得把背景图片的路径发过来
                        this.bgImagePath = res.bgImagePath;
                    } else {
                        toastr.error('上传失败，请重新上传');
                    }
                }).catch(err => {
                    this.uploadError = err.response;
                });
            },

            /**
             * 添加公告
             * TODO 此处并未返回新闻背景图片的链接
             */
            addbulletin() {
                console.log(this.bulletinInfo);
                adminService.addBulletin(this.bulletinInfo.title,this.bgImagePath,this.bulletinInfo.type,this.bulletinInfo.link)
                    .then(response => {
                        let res = response.data;
                        console.log(res);
                        if (res.success) {
                            swal("添加成功!", "您已经成功添加一条公告!", "success");
                            this.isallowed = false;
                        } else {
                            toastr.error('添加失败，请重新添加');
                            this.isallowed = false;
                        }
                    })
                    .catch((err) => {
                        throw  err;
                    });
            },

            // 取消添加公告
            cancelbulletin() {
                this.isallowed = false;
                for(let item in this.bulletinInfo){
                    delete this.bulletinInfo[item];
                }
            },

            // 更改添加公告的类型
            changeType(type){
                if (type === 'bulletin') {
                    this.bulletinType = 1;
                } else if (type === 'school_news') {
                    this.bulletinType = 2;
                } else if (type === 'apart_news') {
                    this.bulletinType = 3;
                }
                this.bulletinInfo.type = this.bulletinType;
                this.isallowed = true;
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

    .bulletin {
        margin-top: 50px;
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
        .bulletin__content {
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

                    &:last-child {
                        margin: 0;
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
                        margin: 15px;

                        .two & {
                            background: $white;
                            color: $accent;
                        }
                    }
                }
            }
        }
    }
</style>