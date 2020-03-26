<?php

use think\facade\Route;

//======================前端 路由======================
//首页
Route::get('/', 'Index/index');
Route::get('tags', 'Common/tags');
//课程页
Route::get('course', 'Index/course')->name('course');
Route::get('course_list/:id', 'Index/courseList')->name('course_list');
Route::get('course_detail/:id', 'Index/courseDetail')->name('course_detail');
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
Route::get('index_login', 'Login/indexLogin')->name('index_login');
Route::get('register', 'Login/register')->name('register');
Route::get('index_register', 'Login/indexRegister')->name('index_register');
Route::get('forget', 'Login/forget')->name('forget');
Route::get('index_forget', 'Login/indexForget')->name('index_forget');
//退出登录
Route::get('out', 'Login/out')->name('out');
//判断是否登录
Route::get('is_login', 'Login/isLogin')->name('is_login');

















