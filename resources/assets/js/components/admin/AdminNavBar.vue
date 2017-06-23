<template>
    <nav id="menu">
        <ul>
            <li>
                <a @click="toggleSubMenu">
                    <icon name="user-o"></icon>
                    <span>用户管理</span>
                    <icon v-if="showSubMenuflag" class="rightToggle" name="caret-down"></icon>
                    <icon v-else class="rightToggle" name="caret-left"></icon>
                </a>
                <!--<transition name="fade" mode="out-in" appear>-->
                <ul class="subMenu">
                    <li @click="changeComponent('admin-useradd','添加用户')"><a><span>添加</span></a></li>
                    <li @click="changeComponent('admin-userdelete','删除用户')"><a><span>删除</span></a></li>
                    <li @click="changeComponent('admin-userupdate','修改用户')"><a><span>修改</span></a></li>
                </ul>
                <!--</transition>-->
            </li>
        </ul>
        <ul>
            <li @click="changeComponent('admin-bulletin','发布公告')">
                <a>
                    <icon name="bullhorn"></icon>
                    <span>发布公告</span>
                </a>
                <!--<transition name="fade" mode="out-in" appear>-->
                <!--<ul class="subMenu">
                            <li><a><span>添加</span></a></li>
                            <li><a><span>删除</span></a></li>
                            <li><a><span>修改</span></a></li>
                        </ul>-->
                <!--</transition>-->
            </li>
        </ul>
        <ul>
            <li @click="changeComponent('admin-checkeva','查看评价')">
                <a>
                    <icon name="eye"></icon>
                    <span>查看评价</span>
                </a>
                <!--<transition name="fade" mode="out-in" appear>-->
                <!--<ul class="subMenu">
                            <li><a><span>添加</span></a></li>
                            <li><a><span>删除</span></a></li>
                            <li><a><span>修改</span></a></li>
                        </ul>-->
                <!--</transition>-->
            </li>
        </ul>
        <ul>
            <li @click="changeComponent('admin-profile','个人信息')">
                <a>
                    <icon name="pencil"></icon>
                    <span>个人信息</span>
                </a>
            </li>
        </ul>
        <ul>
            <li @click="changeComponent('subindex','主页')">
                <a>
                    <icon name="home"></icon>
                    <span>主页</span>
                </a>
            </li>
        </ul>
    </nav>
</template>


<script>

export default {
    data() {
        return {
            showSubMenuflag: true
        }
    },
    methods: {
        toggleSubMenu(event) {
            event.stopPropagation();
            event.preventDefault();
            document.querySelector('.subMenu').classList.toggle('show');
            this.showSubMenuflag = !this.showSubMenuflag;
        },
        changeComponent(type,title) {
            this.$emit('changeComponent', type,title);
        }
    },
    computed: {

    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
$mauve: #7ba57a;
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
*,
*:before,
*:after {
    box-sizing: border-box;
}

* {
    -webkit-tap-highlight-color: rgba(0, 0, 0, 0);
    transform-style: preserve-3d;
}

*:focus {
    outline: none!important;
}

#menu {
    margin-top: 50px;
    background-color: $mauve;
    padding: 0px 0;
    z-index: 10;
    width: 100%;
    color: white;
    -webkit-transition: all 1s ease;
    -moz-transition: all 1s ease;
    transition: all 1s ease;
    opacity: 1;
    font-family: $f;
    ul {
        list-style: none;
        margin-top: 0;
        padding: 0;
        margin-bottom: 0em;
        a {
            &:hover,
            &.active {
                background-color: $heather; 
                // border-left-color: #eee;
                color: #eee;
            }
        }
        li {
            position: relative;
            z-index: 20;
            border-bottom: 1px solid #fff; 
            // padding-left: 5px;
            &:hover {
                cursor: pointer;
            }
            a {
                color: inherit;
                font-size: 16px;
                display: block; 
                padding: 8px 0 8px 7px;
                text-decoration: none;
                -webkit-transition: all 1s ease;
                -moz-transition: all 1s ease;
                transition: all 1s ease;
                font-weight: 600;
                &.active+ul {
                    display: block;
                }
                span {
                    padding-left: 10px;
                }
                .rightToggle {
                    float: right;
                    margin-right: 20px;
                    margin-top: 2px;
                }
            }
            ul {
                margin-top: 0;
                display: none;
                &.show {
                    display: block;
                }
                li {
                    border-bottom: none;
                    &:hover {
                        background-color: $blush;
                        cursor: pointer;
                    }
                    a {
                        padding-left: 25px;
                    }
                }
            }
        }
    }
}
</style>
