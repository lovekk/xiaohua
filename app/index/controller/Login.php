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
        $captcha  = Request::param('captcha');
        $is_name  = UserModel::where('username',$username)->limit(1)->value('password');
        $user_id  = UserModel::where('username',$username)->limit(1)->value('id');
        $ip       = $_SERVER['REMOTE_ADDR'];

        //halt($is_name); //没有值返回null
        //halt(captcha_check($captcha)); //没有值返回null

        if(!captcha_check($captcha)){
            $msg = ['code' => 400, 'msg' => '验证码错误，请点击验证码刷新~'];
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
            session('user_id', $user_id);
            //登录日志
            //记录类型1下载2签到3发布4评论5登录
            UserLogModel::create([
                'username' => $username,
                'type'     => '登录',
                'user_id'  => $user_id,
                'user_ip'  => $ip,
                'content'  => '《第一编程网》我来啦~'
            ]);

            //用户登录数据+1
//            UserModel::update([
//                'login_num' => Db::raw('login_num+1')
//            ], ['id' => $user_id]);

            $userData = UserModel::find($user_id);
            $login_num = $userData->login_num;   //登录数
            $userData->login_num = $login_num +1;

            $vip_type3 = $userData->vip_type;

            if ($vip_type3 == 3){  //判断月费用户
                $vip_end = $userData->vip_end;
                $today = date("Y-m-d");
                if (strtotime($today) > strtotime($vip_end)){
                    $userData->vip_type = 2;
                }
            }
            $userData->save();

            $msg = ['code' => 200, 'user_name' => $username, 'user_id' => $user_id];
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
    public function toRegister()
    {
        $msg = ['code' => 100, 'msg' => '初始化！'];
        //先判断是否有用户名
        $username = Request::param('username');
        $password = Request::param('password');
        $question = Request::param('question');
        $answer   = Request::param('answer');
        $ip       = $_SERVER['REMOTE_ADDR'];

        $captcha  = Request::param('captcha');
        if(!captcha_check($captcha)){
            $msg = ['code' => 300, 'msg' => '验证码错误，请点击验证码刷新~'];
            return json($msg);
        };

        if (empty($username) || empty($password) || empty($answer)){
            $msg = ['code' => 400, 'msg' => '注册信息不完整！'];
            return json($msg);
        }

        if (!empty($username) && !empty($password) && !empty($answer)){
            $num = rand(1,20);
            $created = [
                'username' => $username,
                'password' => $password,
                'question' => $question,
                'answer'   => $answer,
                'head_img'   => 'img/20200202\\'.$num.'.jpg'
            ];

            $data = UserModel::create($created);
            $user_id = $data->id;
            //登录日志
            //记录类型1下载2签到3发布4评论5登录6注册7充值
            $user = UserLogModel::create([
                'username'  =>  $username,
                'type'  =>  '注册',
                'user_id' =>  $user_id,
                'user_ip' =>  $ip,
                'content' =>  '成功注册《第一编程网》！'
            ]);

            $msg = ['code' => 200, 'msg'=>'成功注册《第一编程网》！','user_name' => $username, 'user_id' => $user_id];
            return json($msg);
        }
        //return redirect('index');
        //登录成功挑战到首页
        //登录失败提示错误信息
        return json($msg);
    }


    //注册判断是否重名
    public function toJudge()
    {
        $msg = ['code' => 100, 'msg' => '初始化！'];
        //先判断是否有用户名
        $username = Request::param('username');
        //模型使用find方法查询，如果数据不存在返回Null，否则返回当前模型的对象实例
//        $is_name = UserModel::where('username','=',$username)->select();
        $is_name = UserModel::where('username', $username)->find();
        if(!$is_name){
            $msg = ['code' => 200, 'msg' => '用户名可以用'];
            return json($msg);
        }else{
            $msg = ['code' => 600, 'msg' => '用户名重复了'];
            return json($msg);
        }
    }


    //忘记密码页面
    public function forget()
    {
        return View::fetch();
    }



    //找回密码检查问题
    public function checkQuestion()
    {
        $msg = ['code' => 100, 'msg' => '初始化！'];
        //先判断是否有用户名
        $username = Request::param('username');
        $question = Request::param('question');
        $answer = Request::param('answer');

        $captcha  = Request::param('captcha');
        if(!captcha_check($captcha)){
            $msg = ['code' => 400, 'msg' => '验证码错误，请点击验证码刷新~'];
            return json($msg);
        };

        //模型使用find方法查询，如果数据不存在返回Null，否则返回当前模型的对象实例
        $is_name = UserModel::where('username', $username)->find();
        if($is_name){
            $user_answer = UserModel::where('username', $username)->value('answer');
            $user_question = UserModel::where('username', $username)->value('question');
            if ($answer == $user_answer && $user_question == $question){
                $msg = ['code' => 200, 'msg' => '成功匹配！请设置新密码~', 'data' => $username.$is_name];
            }else{
                $msg = ['code' => 400, 'msg' => '用户名与问题答案不匹配', 'data' => $username.$is_name];
            }
            return json($msg);
        }else{
            $msg = ['code' => 400, 'msg' => '用户名不存在','data' => $username.$is_name];
            return json($msg);
        }
    }


    //找回密码逻辑
    public function toForget()
    {
        $msg = ['code' => 100, 'msg' => '初始化！'];
        //先判断是否有用户名
        $username = Request::param('username');
        $question = Request::param('question');
        $answer = Request::param('answer');
        $password = Request::param('password');
        //模型使用find方法查询，如果数据不存在返回Null，否则返回当前模型的对象实例
        $is_name = UserModel::where('username', $username)->find();
        if($is_name){
            $user_answer = UserModel::where('username', $username)->value('answer');
            $user_question = UserModel::where('username', $username)->value('question');
            if ($answer == $user_answer && $user_question == $question){
                $user = UserModel::where('username', $username)->find();
                $user->password = $password;
                $user->save();
                $msg = ['code' => 200, 'msg' => '设置成功，请登录', 'data' => $username.$is_name];
            }else{
                $msg = ['code' => 400, 'msg' => '用户名与问题答案不匹配', 'data' => $username.$is_name];
            }
            return json($msg);
        }else{
            $msg = ['code' => 400, 'msg' => '用户名不存在','data' => $username.$is_name];
            return json($msg);
        }
    }


    //退出逻辑
    public function out()
    {
        Session::clear();
//        return View::fetch('index/index');
        return redirect('/');
    }


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
