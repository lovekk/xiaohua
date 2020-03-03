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
//首页
Route::get('index', 'Index/index')->name('index');
Route::get('main', 'Index/main')->name('main');

//管理员列表
Route::get('admin_list', 'Admin/index')->name('admin_list');
//课程列表
Route::get('course_list', 'Course/course')->name('course_list');
Route::get('classification', 'Course/classification')->name('classification');


//Route::group('xiaohua', function () {
//    //首页
//    Route::get('index', 'admin.index/index');
//    Route::get('mian', 'admin.index/main')->name('main');
//
//    //管理员列表
//    Route::get('admin_list', 'admin.admin/index')->name('admin_list');
//    //课程列表
//    Route::get('course_list', 'admin.course/course')->name('course_list');
//    Route::get('classification', 'admin.course/classification')->name('classification');
//});


//id user_id设置为数值类
Route::pattern(['id'=>'\d+','user_id'=>'\d+']);
















