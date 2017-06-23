
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// 引入vue-bootstrap
import BootstrapVue from 'bootstrap-vue';
Vue.use(BootstrapVue);
import 'bootstrap/dist/css/bootstrap.css';
import 'bootstrap-vue/dist/bootstrap-vue.css';

import 'sweetalert/dev/sweetalert.scss';

// 图标
import 'vue-awesome/icons';
import Icon from 'vue-awesome/components/Icon';
Vue.component('icon', Icon);

// 添加cookie的封装
var VueCookie = require('vue-cookie');
Vue.use(VueCookie);

// toastr配置
window.toastr = require('toastr/build/toastr.min.js');
import 'toastr/build/toastr.css';
window.toastr.options = {
    positionClass: "toast-bottom-right",
    showDuration: "300",
    hideDuration: "500",
    timeOut: "500",
    extendedTimeOut: "1000",
    showEasing: "swing",
    hideEasing: "linear",
    showMethod: "fadeIn",
    hideMethod: "fadeOut"
};

// 引入路由
import VueRouter from 'vue-router';
Vue.use(VueRouter);

// 评分
import StarRating from 'vue-star-rating';
Vue.component('star-rating', StarRating);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// 通用组件
Vue.component('example', require('./components/Example.vue'));
Vue.component('register', require('./components/Register.vue'));
Vue.component('login', require('./components/Login.vue'));
Vue.component('appheader', require('./components/AppHeader.vue'));
Vue.component('mainpage', require('./components/Main.vue'));
Vue.component('subindex', require('./components/SubIndex.vue'));

// Admin相关的组件
Vue.component('adminnavbar', require('./components/admin/AdminNavBar.vue'));
Vue.component('admin-bulletin', require('./components/admin/Bulletin.vue'));
Vue.component('admin-checkeva', require('./components/admin/Checkeva.vue'));
Vue.component('admin-useradd', require('./components/admin/UserAdd.vue'));
Vue.component('admin-userdelete', require('./components/admin/UserDelete.vue'));
Vue.component('admin-userupdate', require('./components/admin/UserUpdate.vue'));
Vue.component('admin-profile-update', require('./components/admin/ProfileUpdate.vue'));

// 学生相关的组件
Vue.component('studentnavbar',require('./components/student/StudentNavBar.vue'));
Vue.component('student-evaeachother',require('./components/student/StuEvaEachOther.vue'));
Vue.component('student-profileupdate',require('./components/student/StuProfileUpdate.vue'));
Vue.component('student-showratelist',require('./components/student/StuShowRateIist.vue'));
Vue.component('student-showratetable',require('./components/student/StuShowRateTable.vue'));

// 教师相关的组件
Vue.component('teachernavbar',require('./components/teacher/TeacherNavBar.vue'));
Vue.component('teacher-bundleeva',require('./components/teacher/TeaEvaBundle.vue'));
Vue.component('teacher-profileupdate',require('./components/teacher/TeaProfileUpdate.vue'));
Vue.component('teacher-showrating',require('./components/teacher/TeaShowRating.vue'));
Vue.component('teacher-updateeva',require('./components/teacher/TeaUpdateEva.vue'));

// 柱状图组件
Vue.component('bar',require('./components/BarChart.vue'));
// 折线图组件
Vue.component('lines',require('./components/LineChart.vue'));
// 雷达图
Vue.component('radar',require('./components/Radarchart.vue'));

// Rating 评价的组件
Vue.component('rating', require('./components/Rating.vue'));
 
const app = new Vue({
    el: '#app'
});
