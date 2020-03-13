<?php
namespace app\xiaohua\controller;

use app\BaseController;
use think\facade\Request;
use think\facade\View;
use think\facade\Validate;
use app\xiaohua\model\Admin as AdminModel;
use app\xiaohua\model\AdminLog as AdminLogModel;

use think\facade\Session;
use think\middleware\SessionInit;

class Login extends BaseController
{

    /**
     * 后台登录视图
     */
    public function login()
    {
        //渲染模板最常用的是控制器类在继承系统控制器基类（ \think\Controller ）后调用 fetch 方法
        // 不带任何参数 自动定位当前操作的模板文件
        return View::fetch();
    }


    /**
     * 登录逻辑
     */
    public function goLogin()
    {
        //$msg = ['code' => 200, 'msg' => config('message.success')];
        $msg = ['code' => 100, 'msg' => '初始化！'];
        //先判断是否有用户名
        $username = Request::param('username');
        $password = Request::param('password');
        $captcha = Request::param('captcha');
        $is_name = AdminModel::where('username',$username)->limit(1)->value('password');
        $ip = $_SERVER['REMOTE_ADDR'];

        //halt($is_name); //没有值返回null
        //halt(captcha_check($captcha)); //没有值返回null
        if(!captcha_check($captcha)){
            $msg = ['code' => 400, 'msg' => '验证码错误！'];
            return json($msg);
        };
        if ($is_name == null){
            $msg = ['code' => 100, 'msg' => '管理员不存在！'];
            return json($msg);
        }

        //再匹配密码和验证码
        if ($is_name !== $password || empty($password)){
            $msg = ['code' => 300, 'msg' => '密码错误！'];
            return json($msg);
        }

        if (!empty($password) && $is_name == $password){
            //登录成功 存入session
            session('admin_name', $username);

            //登录日志
            $user = AdminLogModel::create([
                'username'  =>  $username,
                'ip' =>  $ip
            ]);

            $msg = ['code' => 200, 'msg' => '登录成功！' . session('admin_name')];
            return json($msg);
        }
        //return redirect('index');
        //登录成功挑战到首页
        //登录失败提示错误信息
        return json($msg);
    }

    /**
     * 退出
     */
    public function outLogin()
    {
        //渲染模板最常用的是控制器类在继承系统控制器基类（ \think\Controller ）后调用 fetch 方法
        // 不带任何参数 自动定位当前操作的模板文件
        // 删除
        session('admin_name', null);
        // 清除session
        session(null);
        return redirect('admin_login');
    }
}
