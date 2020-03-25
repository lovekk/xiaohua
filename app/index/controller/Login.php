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
use think\facade\Request;
use think\facade\View;

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
        //$ip = $_SERVER['REMOTE_ADDR'];

        //halt($is_name); //没有值返回null
        //halt(captcha_check($captcha)); //没有值返回null
        if(!captcha_check($captcha)){
            $msg = ['code' => 400, 'msg' => '验证码错误！'];
            return json($msg);
        };
        if ($is_name == null){
            $msg = ['code' => 100, 'msg' => '用户名不存在！'];
            return json($msg);
        }

        //再匹配密码和验证码
        if ($is_name !== $password || empty($password)){
            $msg = ['code' => 300, 'msg' => '密码错误！'];
            return json($msg);
        }

        if (!empty($password) && $is_name == $password){
            //登录成功 存入session
            session('index_name', $username);

            //登录日志
            /*$user = AdminLogModel::create([
                'username'  =>  $username,
                'ip' =>  $ip
            ]);*/

            $msg = ['code' => 200, 'msg' => '登录成功！' . session('index_name')];
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



}
