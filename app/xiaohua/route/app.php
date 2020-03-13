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
    //课程
    Route::get('course_list', 'Course/course')->name('course_list');  //列表
    Route::get('course_add', 'Course/courseAdd')->name('course_add');  //新增视图
    Route::post('add_course', 'Course/addCourse')->name('add_course');  //新增方法
    Route::get('course_detail', 'Course/courseDetail')->name('course_detail');  //详情视图
    Route::get('del_course', 'Course/delCourse')->name('del_course');  //删除方法
    //课程分类
    Route::get('classification', 'Course/classification')->name('classification');  //列表
    Route::get('classification_add', 'Course/classificationAdd')->name('classification_add');  //新增视图
    Route::post('add_classification', 'Course/addClassification')->name('add_classification');  //新增方法
    Route::get('classification_update/:id', 'Course/classificationUpdate')->name('classification_update');  //修改视图
    Route::post('update_classification', 'Course/updateClassification')->name('update_classification');  //修改方法
    Route::post('del_classification', 'Course/delClassification')->name('del_classification');  //删除方法
    //课程评论
    Route::get('comment_list', 'Course/comment')->name('comment_list');  //列表
    Route::get('comment_add', 'Course/commentAdd')->name('comment_add');  //新增视图
    Route::get('add_comment', 'Course/addComment')->name('add_comment');  //新增方法
    Route::get('del_comment', 'Course/delComment')->name('del_comment');  //删除方法
})->middleware(\app\xiaohua\middleware\AdminLogin::class);















