<template>
    <div class="checkeva">
        <p>请输入学号查询学生评分</p>
    
        <!-- 所要查询的学期 -->
        <div class="select_join">
            <select v-model="selectterm" id="select_term" @change="getterm" >
                <option value="-1" selected>请先选择所要查询的学期</option>
                <option value="1">第一学期</option>
                <option value="2">第二学期</option>
                <option value="3">第三学期</option>
                <option value="4">第四学期</option>
                <option value="5">第五学期</option>
                <option value="6">第六学期</option>
                <option value="7">第七学期</option>
            </select>
        </div>

        <!-- 搜索框 -->
        <div class="searchTarget">
            <form @submit.prevent="showAllSCore" class="search" :class="{notallowed: isallowed}">
                <input　v-model="selectID" :disabled="isallowed" class="searchTerm" placeholder="请输入学号" />
                <input @click="showAllSCore" class="searchButton" type="button" />
            </form>
        </div>

        <!-- 展示搜索结果 -->
        <div class="scoreitems" v-if="showResult">
            <ul>
                <li>
                    <span>课程学习</span>
                    <div class='rating'>
                        <rating :increment="0.01" :readonly="true" :rating="summaryScore.Mcourse"></rating>
                    </div>
                </li>
                <li>
                    <span>活动情况</span>
                    <div class='rating'>
                        <rating :readonly="true" :rating="summaryScore.Mactivity"></rating>
                    </div>
                </li>
                <li>
                    <span>同学互评</span>
                    <div class='rating'>
                        <rating :increment="0.01" :readonly="true" :rating="summaryScore.Mclassmates"></rating>
                    </div>
                </li>
                <li>
                    <span>道德法律</span>
                    <div class='rating'>
                        <rating :readonly="true" :rating="summaryScore.Mlawpolicy"></rating>
                    </div>
                </li>
                <li>
                    <span>体&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;育</span>
                    <div class='rating'>
                        <rating :readonly="true" :rating="summaryScore.Mpe"></rating>
                    </div>
                </li>
                <li>
                    <span>总&nbsp;&nbsp;成&nbsp;绩</span>
                    <div class='rating'>
                        <rating :increment="0.01" :readonly="true" :rating="summaryScore.Mscore"></rating>
                    </div>
                </li>
            </ul>
        </div>
    
    </div>
</template>

<script>
import * as studentService from '../../service/studentService';
export default{
    data () {
        return {
            isallowed: true, // 是否允许
            selectterm: -1, // 所选择的学期
            selectID: '', // 所查询的学生ID
            showResult: false,
            summaryScore: {}
        }
    },
    methods: {
        getterm($event){
            this.isallowed = false;
            console.log(this.selectterm);
        },
        // 获得所有的成绩
        showAllSCore(){
            console.log(this.selectID);
            studentService.getAllScore(this.selectID,this.selectterm)
            .then(response => {
                let res = response.data;
                if(res.success){
                    this.summaryScore = res.summary;
                    this.showResult = true;
                }else{
                    toastr.error('网络错误，请稍后重试！');
                }
            })
            .catch(err => {
                throw err;
            });
        }
    }
}
</script>

<style scoped lang="scss">
.checkeva {
    margin-top: 50px; 
    
    ul {
        width: 100%;
        list-style: none;
        padding: 0;
        li {
            line-height: 2.5;
            .moresub {
                &:after {
                    content: '▼';
                    margin-left: 5px;
                    transition: all 1s linear;
                }
            }
            .morepub {
                &:after {
                    content: '▲';
                    margin-left: 5px;
                    transition: all 1s linear;
                }
            }
            .dropdown {
                width: 100%;
                display: none;
                background: rgba(187, 238, 255, .8);
                ul,
                li {
                    background: transparent;
                }
                span {
                    text-indent: 2em;
                }
            }
            background: rgba(153, 204, 255, .8);
            &:nth-child(2n) {
                background: rgba(119, 170, 255, .8);
            }
            &:last-child {
                background: rgba(51, 102, 255, 0.8);
            }
            &:first-child {
                &:hover {
                    cursor: pointer;
                }
            }
            span {
                display: inline-block;
                width: 49%;
                text-indent: 2em;
            }
            div {
                display: inline-block;
                width: 49%;
            }
        }
    }
    
    .rating {
        padding-top: .5em;
        text-indent: 0.35em;
    }
    .scoreitems {
            border-radius: 2px;
            background: #eee;
            padding: 5px;
            margin-top: 10px;
            button {
                display: block;
                width: 100%;
                color: white;
                font-size: 1.5em;
                line-height: 2.5;
                text-align: left;
                &:hover {
                    background-color: #ddd;
                }
                border-bottom: 2px solid white;
            }
        }

    // 搜索的所有样式
    .select_join {
        background-color: #ddd;
        width: 100%;
        height: 40px;
        overflow: hidden;
        border: #FEFEFE 2px solid;
        -webkit-border-radius: 4px;
        line-height: 40px;
        padding-left: 10px;
        border-radius: 4px; // -webkit-box-shadow: inset 0px 0px 10px 1px #FEFEFE;
        // box-shadow: inset 0px 0px 10px 1px #FEFEFE;
        select {
            background: transparent;
            width: 97%;
            font-size: 7pt;
            color: rgba(0, 0, 0, .6);
            border: 0;
            border-radius: 0;
            height: 28px; // -webkit-appearance: none;
            padding-right: 20px;
            &:focus {
                outline: none;
            }
        }
    }
    .search {
        width: 100%;
        margin: 20px 0 10px 0;
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
}
</style>