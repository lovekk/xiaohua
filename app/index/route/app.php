<?php

use think\facade\Route;

//======================前端 路由======================
//首页
Route::get('/', 'Index/index');
//课程页
Route::get('course', 'Index/course')->name('course');                               //课程页面
Route::get('course_list/:id', 'Index/courseList')->name('course_list');             //课程列表
Route::get('course_detail/:id', 'Index/courseDetail')->name('course_detail');       //课程详情
Route::post('down_course', 'Api/downCourse')->name('down_course');                  //下载课程
Route::get('link_lose', 'Index/linkLose')->name('link_lose');                      //链接失效反馈页面
Route::get('link_ask', 'Index/linkAsk')->name('link_ask');                         //求助资源页面
Route::get('link_share', 'Index/linkShare')->name('link_share');                   //分享课程页面
Route::post('link_submit', 'Api/linkSubmit')->name('link_submit');                 //提交动作
//源码页
Route::get('code', 'Index/code')->name('code');           //源码页面 列表
//评论
Route::post('comment', 'Api/comment')->name('comment');   //评论
//会员页
Route::get('vip', 'Index/vip')->name('vip');              //会员页面
//签到页
Route::get('sign', 'Index/sign')->name('sign');           //签到页页面
Route::post('to_sign', 'Api/toSign')->name('to_sign');    //签到页签到逻辑
//个人主页
Route::get('my', 'Index/my')->name('my');                 //个人主页页面
//关于我们
Route::get('about', 'Index/about')->name('about');        //关于我们页面
//搜索
Route::get('search_result', 'Index/searchResult')->name('search_result');       //搜索功能
//登录页
Route::get('login', 'Login/login')->name('login');                     //登录页面
Route::get('index_login', 'Login/indexLogin')->name('index_login');    //前端登录逻辑
Route::get('out', 'Login/out')->name('out');                           //退出登录
Route::get('is_login', 'Login/isLogin')->name('is_login');             //判断是否登录
//注册页
Route::get('register', 'Login/register')->name('register');            //注册页面
Route::post('to_judge', 'Login/toJudge')->name('to_judge');            //判断用户名是否重复
Route::post('to_register', 'Login/toRegister')->name('to_register');   //注册信息
//忘记密码
Route::get('forget', 'Login/forget')->name('forget');                           //忘记密码页面
Route::post('to_forget', 'Login/toForget')->name('to_forget');                  //重置密码逻辑
Route::post('check_question', 'Login/checkQuestion')->name('check_question');   //重置密码逻辑



















