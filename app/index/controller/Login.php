<?php
/**
 * Created by PhpStorm.
 * User: zk
 * Date: 2020/2/28
 * Time: 14:45
 */

namespace app\index\controller;

use app\BaseController;
use think\facade\Db;
use app\index\model\User as UserModel;
use app\index\model\UserLog as UserLogModel;
use think\facade\Request;
use think\facade\View;
use think\facade\Session;

class Login extends BaseController
{

    //登录页面
    public function login()
    {
        return View::fetch();
    }


    //登录逻辑
    public function indexLogin()
    {
        //$msg = ['code' => 200, 'msg' => config('message.success')];
        $msg = ['code' => 100, 'msg' => '初始化！'];
        //先判断是否有用户名
        $username = Request::param('username');
        $password = Request::param('password');
        $captcha = Request::param('captcha');
        $is_name = UserModel::where('username',$username)->limit(1)->value('password');
        $user_id = UserModel::where('username',$username)->limit(1)->value('id');
        $ip = $_SERVER['REMOTE_ADDR'];

        //halt($is_name); //没有值返回null
        //halt(captcha_check($captcha)); //没有值返回null
        if(!captcha_check($captcha)){
            $msg = ['code' => 400, 'msg' => '验证码错误！'];
            return json($msg);
        };
        if ($is_name == null){
            $msg = ['code' => 100, 'msg' => '用户名或密码错误！'];
            return json($msg);
        }

        //再匹配密码和验证码
        if ($is_name !== $password || empty($password)){
            $msg = ['code' => 300, 'msg' => '用户名或密码错误'];
            return json($msg);
        }

        if (!empty($password) && $is_name == $password){
            //登录成功 存入session
            session('user_name', $username);

            //登录日志
            //记录类型1下载2签到3发布4评论5登录
            $user = UserLogModel::create([
                'username'  =>  $username,
                'type'  =>  5,
                'user_id' =>  $ip,
                'user_ip' =>  $user_id
            ]);

            $msg = ['code' => 200, 'msg' => '登录成功！' . session('user_name')];
            return json($msg);
        }
        //return redirect('index');
        //登录成功挑战到首页
        //登录失败提示错误信息
        return json($msg);
    }


    //注册页面
    public function register()
    {
        return View::fetch();
    }


    //注册逻辑
    public function indexRegister()
    {
        return View::fetch();
    }


    //忘记密码页面
    public function forget()
    {
        return View::fetch();
    }


    //找回密码逻辑
    public function indexForget()
    {
        return View::fetch();
    }


    //退出逻辑
//    public function out()
//    {
//        Session::clear();
//        return View::fetch('index/course');
//    }


    //是否登录
    public function isLogin()
    {
        if (session('?user_name')){
            $user_name = session('user_name');
        }
        //获取ID
        $user_data = UserModel::where('username','=',$user_name)->find();
        $code = $user_data ? 200:404;
        $msg = ['code' => $code, 'user_name' => $user_name,'user_data' => $user_data, ];

        return json($msg);
    }



}
