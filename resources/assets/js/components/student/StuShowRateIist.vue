<template>
    <div id="stushowRateList">
        <!-- 显示所有的学期 -->
        <div class="totalterm">
            <!--<button class="specificTerm" @click="activeterm(0,$event)">所有学期</button>-->
    
            <button class="specificTerm" v-for="(term,index) in totalTerm" @click="activeterm(parseInt(termCount) - index,$event)">{{term}}
                                    </button>
        </div>
        <!-- 所有的成绩 -->
        <div class="scoreitems" v-if="showAllScore">
            <ul>
                <li @click="toggleDropdown('dropdown')">
                    <span ref="more" class="moresub">课程学习</span>
                    <div class='rating'>
                        <rating :increment="0.01" :readonly="true" :rating="scoreSummary.Mcourse"></rating>
                    </div>
                    <!-- 该学期所有的课程成绩列表 -->
                    <div v-if="showDropDown" class="dropdown" ref="dropdown">
                        <ul v-if="loadOver">
                            <li v-for="course in courseLists">
                                <span>{{course.Cname}}</span>
                                <div class='rating'>
                                    <rating :size="15" :readonly="true" :rating="course.Scmark"></rating>
                                </div>
                            </li>
                        </ul>
                    </div>
                </li>
                <li>
                    <span>活动情况</span>
                    <div class='rating'>
                        <rating :readonly="true" :rating="scoreSummary.Mactivity"></rating>
                    </div>
                </li>
                <li>
                    <span>同学互评</span>
                    <div class='rating'>
                        <rating :increment="0.01" :readonly="true" :rating="scoreSummary.Mclassmates"></rating>
                    </div>
                </li>
                <li>
                    <span>道德法律</span>
                    <div class='rating'>
                        <rating :readonly="true" :rating="scoreSummary.Mlawpolicy"></rating>
                    </div>
                </li>
                <li>
                    <span>体&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;育</span>
                    <div class='rating'>
                        <rating :readonly="true" :rating="scoreSummary.Mpe"></rating>
                    </div>
                </li>
                <li>
                    <span>总&nbsp;&nbsp;成&nbsp;绩</span>
                    <div class='rating'>
                        <rating :increment="0.01" :readonly="true" :rating="scoreSummary.Mscore"></rating>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import * as studentService from '../../service/studentService';
    import * as config from '../../config';
    export default {
        data() {
            return {
                userid: config.USER_ID, // 获取用户的ID
                userrole: config.USER_ROLE, // 获取用户的角色（admin，student，teacher）
                termCount: -1, // 总学期数
                selectedTerm: 0, // 所想要查询的学期，默认为0，代表所有学期
                totalTerm: [], // 总学期的学期中文名，数组
                showAllScore: false, // 在未点击查看哪一学期时不显示
                scoreSummary: {}, // 所有成绩，对象
                courseLists: [], // 该学生本学期所有课程和成绩
                loadOver: false, // 课程列表尚未加载完毕flag
                showDropDown: false
            }
        },
        computed: {},
        methods: {
            toggleDropdown(ref) {
                studentService.getCourseList(this.userid, this.selectedTerm)
                    .then(response => {
                        let res = response.data;
                        this.showDropDown = false;
                        this.courseLists =[];
                        if (res.success) {
                            if (res.courseList.length > 0) {
                                this.courseLists = res.courseList;
                                this.showDropDown = true;
                            } else {
                                toastr.info('您该学期无课程信息！');
                            }
                        } else {
                            toastr.error('网络错误，请刷新重试');
                        }
                        this.loadOver = true;
                    })
                    .catch(err => {
                        throw err;
                    });
                if (this.showDropDown) {
                    this.$refs[ref].classList.toggle('showBlock');
                    if (this.$refs.more.className === 'moresub') {
                        console.log('moresub');
                        this.$refs.more.className = 'morepub';
                    } else {
                        this.$refs.more.className = 'moresub';
                    }
                }
            },
            // 点击选择了哪一个学期后显示该学期的成绩
            activeterm(selectedTerm, event) {
                this.selectedTerm = selectedTerm;
                console.log(this.selectedTerm);
                $('.specificTerm').removeClass('active');
                event.target.classList.add('active');
                this.showAllScore = true;
                studentService.getAllScore(this.userid, this.selectedTerm)
                    .then(response => {
                        let res = response.data;
                        if (res.success) {
                            this.scoreSummary = res.summary;
                        } else {
                            toastr.error('网络错误，请刷新重试');
                        }
                    })
                    .catch(err => {
                        throw err;
                    });
            }
        },
        created: function() {
            studentService.getAllTerm(this.userid, (value) => {
                this.termCount = parseInt(value);
                // 总学期的学期中文名，数组
                this.totalTerm = Array(this.termCount).fill().map((item, index) => {
                    let chineseName = ['第七学期', '第六学期', '第五学期', '第四学期', '第三学期', '第二学期', '第一学期'];
                    let start = chineseName.length - this.termCount;
                    return chineseName[start + index];
                });
            })
    
        }
    }
</script>

<style lang="scss" scoped>
    .showBlock {
        display: block !important;
    }
    
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
    
    #stushowRateList {
        margin-top: 50px;
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
        .totalterm {
            button {
                color: white;
                margin: 5px;
                background-color: rgba(211, 84, 0, .5);
                border: none;
                padding: 10px;
                &:hover {
                    background-color: rgba(211, 84, 0, .7);
                }
                &:focus,
                &:active {
                    outline: 0;
                }
                &.active {
                    background-color: #659664;
                }
            }
        }
    }
</style>