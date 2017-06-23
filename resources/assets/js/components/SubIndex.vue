<template>
    <div class="subindex">
        <div class="imageslider">
            <slider animation="fade">
                <slider-item>
                    <div>
                        <img :src="bulletin[0].Bphoto">
                        <div class="caption__text">
                            <a :href="bulletin[0].Blink" target="single">{{bulletin[0].Btitle}}</a>
                        </div>
                    </div>
                </slider-item>
                <slider-item>
                    <div>
                        <img :src="bulletin[1].Bphoto">
                        <div class="caption__text">
                            <a :href="bulletin[1].Blink" target="single">{{bulletin[1].Btitle}}</a>
                        </div>

                    </div>
                </slider-item>
                <slider-item>
                    <div>
                        <img :src="bulletin[2].Bphoto">
                        <div class="caption__text">
                            <a :href="bulletin[2].Blink" target="single">{{bulletin[2].Btitle}}</a>
                        </div>

                    </div>
                </slider-item>
            </slider>
        </div>
        <div class="newslist">
            <div class="container">
                <div class="row">
                    <div class="col-md-4 historynews">
                        <div class="header">
                            <h6>历史公告</h6>
                            <span>
                                <a href="#" target="single">>></a>
                            </span>
                        </div>
                        <ul>
                            <li v-for="item in bulletin">
                                <a :href="item.Blink" target="single">{{item.Btitle}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4 schoolnews">
                        <div class="header">
                            <h6>校园新闻</h6>
                            <span>
                                <a href="#" target="single">>></a>
                            </span>
                        </div>
                        <ul>
                            <li v-for="item in campusNews">
                                <a :href="item.Blink" target="single">{{item.Btitle}}</a>
                            </li>
                        </ul>
                    </div>
                    <div class="col-md-4 apartmentnews">
                        <div class="header">
                            <h6>院系新闻</h6>
                            <span>
                                <a href="#" target="single">>></a>
                            </span>
                        </div>
                        <ul>
                            <li v-for="item in facultyNews">
                                <a :href="item.Blink" target="single">{{item.Btitle}}</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import * as commonService from '../service/commonService';
    import {Slider, SliderItem} from 'vue-easy-slider';

    export default {
        components: {
            Slider,
            SliderItem
        },
        data(){
            return {
                bulletin: [
                    {Blink:'',Bphoto:'',Btitle:''},
                    {Blink:'',Bphoto:'',Btitle:''},
                    {Blink:'',Bphoto:'',Btitle:''}
                ], // 公告
                campusNews: [], // 校园新闻
                facultyNews: [] // 院系新闻
            }
        },
        created: function(){
            commonService.getHomeNews()
            .then(response => {
                let res = response.data;
                if(res.success){
                    this.bulletin = res.bulletin;
                    this.campusNews = res.campusNews;
                    this.facultyNews = res.facultyNews;
                    console.log(this.bulletin);
                    console.log(this.campusNews);
                    console.log(this.facultyNews);
                }
            })
            .catch(err => {
                throw err;
            });
        }
    }
</script>

<style scoped lang="scss">
    .btn.btn-right:focus {
        box-shadow: none !important;
    }

    .btn:focus, .btn.focus, .btn:active {
        box-shadow: none !important;
    }

    a {
        &:active,
        &:visited,
        &:link {
            text-decoration: none;
            color: rgba(250, 250, 250, .7);
        }
        &:hover {
            color: rgba(250, 250, 250, 1);
        }
    }

    .subindex {
        margin-top: 50px;
    }

    img {
        height: 100%;
        width: 100%;
    }

    // 新闻列表
    .newslist {
        margin-top: 20px;
        .col-md-4 {
            padding: 0;
            &:not(:last-child) {
                padding-right: .5em;
            }
            .header {
                overflow: hidden;
                height: 2.5em;
                line-height: 2.5;
                position: relative;
                margin-bottom: .5em;
                h6 {
                    width: 100%;
                    float: left;
                    line-height: 2.5;
                    color: white;
                    text-align: center;
                }
                span {
                    position: absolute;
                    right: 0;
                    float: right;
                    padding-right: 10px;
                }
            }
            ul {
                list-style: none;
                padding: 0;
                li {
                    & a {
                        color: black;
                    }
                    width: 90%;
                    line-height: 2;
                    height: 2em;
                    white-space: nowrap;
                    overflow: hidden;
                    text-overflow: ellipsis;
                }
            }
            &.historynews {
                & .header {
                    background: #fc6;
                }
            }
            &.schoolnews {
                & .header {
                    background: #33cc99;
                }
            }
            &.apartmentnews {
                & .header {
                    background: #93b;
                }
            }
        }
    }

    button {
        &:focus {
            box-shadow: none;
        }
    }

    .imageslider {
        box-shadow: none !important;
        position: relative;
        .caption__text {
            height: 2em;
            text-align: center;
            line-height: 2em;
            width: 70%;
            margin: 0 auto;
            background: rgba(0, 0, 0, .4);
            color: white;
            font-size: large;
            position: absolute;
            left: 50%;
            top: 70%;
            transform: translate3d(-50%, -50%, 0);
        }
    }
</style>