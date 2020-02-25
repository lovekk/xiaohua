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

//id user_id设置为数值类
Route::pattern(['id'=>'\d+','user_id'=>'\d+']);


//系统测试
//闭包
Route::get('think', function () {
    return 'hello,ThinkPHP6!';
});
//控制器
Route::get('hello/:name', 'Index/hello');


//======================前端======================




//======================后台======================
Route::group('xiaohua', function () {
    Route::get('index', 'admin.index/index');
});





















