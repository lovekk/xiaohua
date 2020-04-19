<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\facade\Route;


//======================后台 路由======================
//登录
Route::get('admin_login', 'Login/login')->name('admin_login');
Route::post('go_login', 'Login/goLogin')->name('go_login');
//退出
Route::get('out_login', 'Login/outLogin')->name('out_login');

Route::group(function(){
    //首页
    Route::get('index', 'Index/index')->name('index');
    Route::get('main', 'Index/main')->name('main');
    //管理员
    Route::get('admin_list', 'Admin/index')->name('admin_list');  //管理员列表
    Route::get('admin_add', 'Admin/adminAdd')->name('admin_add');  //管理员新增视图
    Route::post('add_admin', 'Admin/addAdmin')->name('add_admin');  //管理员新增方法
    Route::get('admin_log', 'Admin/adminLog')->name('admin_log');  //管理员登录日志
    //用户
    Route::get('user_list', 'User/index')->name('user_list');  //用户列表
    Route::get('user_add', 'User/userAdd')->name('user_add');  //用户新增视图
    Route::post('add_user', 'User/addUser')->name('add_user');  //用户新增方法
    Route::get('user_detail/:id', 'User/userDetail')->name('user_detail');  //用户详情
    Route::get('user_log', 'User/userLog')->name('user_log');  //用户日志
    Route::post('change_user', 'User/changeUser')->name('change_user');  //用户IT币
    //课程
    Route::get('course_list', 'Course/course')->name('course_list');  //列表
    Route::get('course_add', 'Course/courseAdd')->name('course_add');  //新增视图
    Route::post('add_course', 'Course/addCourse')->name('add_course');  //新增方法
    Route::get('course_update/:id', 'Course/courseUpdate')->name('course_update');  //修改课程
    Route::post('update_course', 'Course/updateCourse')->name('update_course');  //修改课程
    Route::get('course_detail', 'Course/courseDetail')->name('course_detail');  //详情视图
    Route::get('del_course', 'Course/delCourse')->name('del_course');  //删除方法
    Route::get('course_up', 'Course/courseUp')->name('course_up');  //用户提交
    Route::get('download', 'Course/download')->name('download');  //用户下载记录
    //课程分类
    Route::get('classification', 'Course/classification')->name('classification');  //列表
    Route::get('classification_add', 'Course/classificationAdd')->name('classification_add');  //新增视图
    Route::post('add_classification', 'Course/addClassification')->name('add_classification');  //新增方法
    Route::get('classification_update/:id', 'Course/classificationUpdate')->name('classification_update');  //修改视图
    Route::post('update_classification', 'Course/updateClassification')->name('update_classification');  //修改方法
    Route::post('del_classification', 'Course/delClassification')->name('del_classification');  //删除方法
    //课程评论
    Route::get('comment_list', 'Course/comment')->name('comment_list');  //评论列表
    Route::post('del_comment', 'Course/delComment')->name('del_comment');  //评论删除方法
    Route::get('link_lose', 'Course/linkLose')->name('link_lose');                      //链接失效反馈页面
    Route::get('link_ask', 'Course/linkAsk')->name('link_ask');                         //求助资源页面
    Route::get('link_share', 'Course/linkShare')->name('link_share');                   //分享课程页面
    Route::post('link_submit', 'Course/linkSubmit')->name('link_submit');                 //提交动作
    //订单

})->middleware(\app\xiaohua\middleware\AdminLogin::class);






















