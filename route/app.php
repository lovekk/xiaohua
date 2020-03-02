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


//======================前端======================
//首页
Route::get('/', 'home.index/index');
//课程页
Route::group('course', function () {
    Route::get('list', 'home.Index/course');
});
//课程页
Route::get('course', 'home.index/course')->name('course');
//源码页
Route::get('code', 'home.index/code')->name('code');
//会员页
Route::get('vip', 'home.index/vip')->name('vip');
//签到页
Route::get('sign', 'home.index/sign')->name('sign');
//登录页
Route::get('login', 'home.login/login')->name('login');
Route::get('register', 'home.login/register')->name('register');
//个人主页
Route::get('my', 'home.index/my')->name('my');




//======================后台======================
Route::group('xiaohua', function () {
    //首页
    Route::get('index', 'admin.index/index');
    Route::get('mian', 'admin.index/main')->name('main');

    //管理员列表
    Route::get('admin_list', 'admin.admin/index')->name('admin_list');
    //课程列表
    Route::get('course_list', 'admin.course/course')->name('course_list');
    Route::get('classification', 'admin.course/classification')->name('classification');
});




//id user_id设置为数值类
Route::pattern(['id'=>'\d+','user_id'=>'\d+']);

//系统测试
//闭包
Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});
//控制器
Route::get('hello/:name', 'Index/hello');















