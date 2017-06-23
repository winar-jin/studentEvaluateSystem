<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('login');
});
Route::get('/main', function () {
    return view('main');
});

//for all user
Route::post('login','Common\LoginController@login');
Route::post('profile','Common\ProfileController@profile');//获取个人信息
Route::post('getgrade','Common\GetGradeController@getGrade');//获取学生年级
Route::post('getheaderinfo','Common\GetHeaderInfoController@getHeaderInfo');//获取页面header信息
Route::post('getallscore','Common\GetAllScoreController@getAllScore');//获取特定学生的所有成绩
Route::post('gethomenews','Common\GetHomeNewsController@getHomeNews');//获取主页新闻
Route::post('uploadavatar','Common\UploadAvatarController@uploadAvatar');//上传新头像
Route::post('updateavatar','Common\UpdateAvatarController@updateAvatar');//更新头像
Route::post('updatepassword','Common\UpdatePasswordController@updatePassword');//更新密码

//for admin
Route::post('adminupload','Admin\AdminUploadController@adminupload');//管理员上传文件[用户信息/公告背景]
Route::post('searchinfo','Admin\SearchInfoController@searchinfo');//搜索用户信息
Route::post('broadcast','Admin\BroadcastController@broadcast');//发布公告、新闻
Route::post('profile/admin','Admin\ProfileAdminController@updateProfile');//修改个人信息
Route::post('admin/addoneuser','Admin\AddOneUserController@addOneUser');//单个添加用户
Route::post('admin/deleteoneuser','Admin\DeleteOneUserController@deleteOneUser');//单个删除用户
Route::post('admin/deletegraduates','Admin\DeleteGraduatesController@deleteGraduates');//删除毕业生信息

//for teacher
Route::post('teachersearch','Teacher\TeacherSearchController@teacherSearch');//搜索特定学生课程评价结果
Route::post('profile/teacher','Teacher\ProfileTeacherController@updateProfile');//修改个人信息
Route::post('teacher/getrole','Teacher\GetRoleController@getRole');//获取老师角色
Route::post('teacherupload','Teacher\TeacherUploadController@teacherUpload');//老师上传文件评分
Route::post('teachercomment/subjective','Teacher\GetSubjectiveListController@getSubjectiveList');//主观评价拉出所有学生
Route::post('commentsubjective','Teacher\CommentSubjectiveController@commentSubjective');//老师进行主观评价
Route::post('teacherscoreupdate','Teacher\TeacherScoreUpdateController@updateScore');//修改评价
Route::post('teacher/getcourselist','Teacher\GetCourseListController@getCourseList');//获取课程列表
Route::post('teacher/getstudentscore/bycname',
    'Teacher\GetScoreByCnameController@getScoreByCname');//通过课程名获取学生成绩列表
Route::post('teacher/getstudentscore/bysid',
    'Teacher\GetScoreByIdController@getScoreById');//通过学生号获取学生成绩列表

//for student
Route::post('commentclassmates','Student\CommentClassmatesController@commentClassmates');//同学互评
Route::post('getmclassmates','Student\GetMclassmatesController@getClassmatesMarks');//获取全班同学综合评分
Route::post('profile/student','Student\ProfileStudentController@updateProfile');//修改个人信息
Route::post('student/getcourselist','Student\GetCourseListController@getCourseList');//获取特定学期课程及得分