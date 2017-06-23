<template>
    <header>
        <span class="title">
            <a href="/commentSys/version0/public/main">教师评学系统</a>
        </span>
        <span class="role">{{userrole_zh}}</span>
        <span class="options">
            <span @click="$root.$emit('show::modal','updateheadimg')" class="profile">
                <img :src="avatarImg" />
            </span>
            <span @click="$root.$emit('show::modal','updateheadimg')" class="name">
                {{username}}
            </span>
            <span class="logout" @click="logout">
                <icon name="power-off"></icon>
            </span>
        </span>
    </header>
</template>


<script>
import axios from 'axios';
export default {
    data() {
        return {
            userid: this.$cookie.get('userid__main') || localStorage.getItem('userid__main'), // 获取用户的ID
            userrole: this.$cookie.get('role__main') || localStorage.getItem('role__main'), // 获取用户的角色（admin，student，teacher）
            username: '', // 获取到用户名
            avatarImg: '', // 用户的头像地址
            userrole_zh: ''
        }
    },
    methods: {
        logout() {
            localStorage.removeItem('role__main');
            localStorage.removeItem('userid__main');
            this.$cookie.delete('role__main');
            this.$cookie.delete('userid__main');
            window.location.replace('/bishe/version1.0/public');
        },
        checkProfile() {
            console.log("Checkout the profile.");
        },
        showMessage() {
            console.log("show me the unread messsages.");
        }
    },
    computed: {

    },
    beforeCreate: function () {
        let userid = this.$cookie.get('userid__main') || localStorage.getItem('userid__main'); // 获取用户的ID
        let userrole = this.$cookie.get('role__main') || localStorage.getItem('role__main');
        axios.post('getheaderinfo', {
            role: userrole,
            id: userid
        })
            .then(response => {
                let res = response.data;
                // console.log(res);
                // 当登录成功后，将用户的角色和用户ID存入cookie
                if (res.success === true) {
                    this.username = res.headerinfo.name;
                    if(res.headerinfo.photoPath){
                        this.avatarImg = res.headerinfo.photoPath;
                    } else{
                        this.avatarImg = 'imags/default.jpeg';
                    }                   
                }
            })
            .catch(err => {
                throw err;
            });
    },
    created() {
        if (this.userrole === 'admin') {
            this.userrole_zh = '管理员';
        } else if (this.userrole === 'teacher') {
            this.userrole_zh = '教师';
        } else if (this.userrole === 'student') {
            this.userrole_zh = '学生';
        } else {
            this.userrole_zh = '';
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
$mauve: #659664;
$heather: #C0D9D4;
$blush: #dfece9;
$grey: #343434;
$easeOutCubic: cubic-bezier(0.215, 0.610, 0.355, 1.000);
$f: "Microsoft YaHei",
"brandon-grotesque",
"Brandon Grotesque",
"Source Sans Pro",
"Segoe UI",
Frutiger,
"Frutiger Linotype",
"Dejavu Sans",
"Helvetica Neue",
Arial,
sans-serif;
$p: 12px;
*,
*:before,
*:after {
    box-sizing: border-box;
}

a {
    &:active,
    &:visited,
    &:link {
        text-decoration: none;
        color: rgba(255, 255, 255, 1);
    }
}

* {
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    transform-style: preserve-3d;
}

.dropdown {
    height: 200px;
    background: red;
}

*:focus {
    outline: none!important;
}

header {
    box-shadow: 0 0 10px #000;
    height: 50px;
    width: 100%;
    background: $mauve;
    color: white;
    .title {
        margin: 0px 0px 0px 20px;
        line-height: 50px;
        font-family: $f;
        text-shadow: 0px 0px 1px #fff;
        font-size: medium;
    }
    .role {
        margin-left: 10px;
        &:before {
            content: '|';
            margin: 0 5px;
        }
    }
    .options {
        float: right;
        height: 50px;
        display: flex;
        align-items: center;
        .profile {
            display: inline-block;
            width: 30px;
            height: 30px;
            border: 1px solid white;
            border-radius: 50%;
            box-shadow: 0 0 5px #eee;
            img {
                width: 30px;
                height: 30px;
                border-radius: 50%;
                border: none;
            }
            &:hover {
                border-color: #ccc;
                cursor: pointer;
            }
        }
        .message {
            margin-right: 20px;
            &:hover {
                color: #ccc;
                cursor: pointer;
            }
        }
        .name {
            margin-right: 20px;
            font-size: 0.8em;
            &:before {
                content: '|';
                padding-left: 10px;
            }
            &:hover{
                cursor: pointer;
            }
        }
        .logout {
            margin-right: 20px;
            &:hover {
                color: #ccc;
                cursor: pointer;
            }
        }
    }
}
</style>
