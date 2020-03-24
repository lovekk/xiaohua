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


//======================前端 路由======================
//首页
Route::get('/', 'Index/index');
//课程页
Route::get('course', 'Index/course')->name('course');
Route::get('course_list', 'Index/courseList')->name('course_list');
Route::get('course_detail', 'Index/courseDetail')->name('course_detail');
//源码页
Route::get('code', 'Index/code')->name('code');
//会员页
Route::get('vip', 'Index/vip')->name('vip');
//签到页
Route::get('sign', 'Index/sign')->name('sign');
//个人主页
Route::get('my', 'Index/my')->name('my');
//关于我们
Route::get('about', 'Index/about')->name('about');
//登录页
Route::get('login', 'Login/login')->name('login');
Route::get('register', 'Login/register')->name('register');
Route::get('forget', 'Login/forget')->name('forget');

















