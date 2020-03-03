<?php
// 应用公共文件

//显示信息
function show_res($status, $message, $data, $HttpStatus = 200){
    $result = [
        'status' => $status,
        'message' => $message,
        'result' => $data
    ];
    return json($result, $HttpStatus);
}


//错误信息
function show_error($status, $message = '错误', $data, $HttpStatus = 200){
    $result = [
        'status' => $status,
        'message' => $message,
        'result' => $data
    ];
    return json($result, $HttpStatus);
}


//后台返回登录
function back_admin_login(){
    return redirect('/admin/login');
}


//后台返回首页
function back_admin_index(){
    return redirect('/admin/Index');
}


//后台返回错误页面
function back_error(){
    return redirect('/admin/AdminBaseAccess/errorView');
}