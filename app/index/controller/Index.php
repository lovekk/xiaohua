<?php
/**
 * Created by PhpStorm.
 * User: zk
 * Date: 2020/2/26
 * Time: 14:45
 */

namespace app\index\controller;

use app\BaseController;
use think\facade\Db;
use app\model\User as UserModel;
use think\facade\Request;
use think\facade\View;

class Index extends BaseController
{

    //首页
    public function index()
    {
        return View::fetch();
    }


    //课程
    public function course()
    {
        return View::fetch();
    }


    //源码
    public function code()
    {
        return View::fetch();
    }


    //vip
    public function vip()
    {
        return View::fetch();
    }


    //签到
    public function sign()
    {
        return View::fetch();
    }


    //登录
    public function login()
    {
        return View::fetch();
    }


    //注册
    public function register()
    {
        return View::fetch();
    }


    //个人主页
    public function my()
    {
        return View::fetch();
    }


}
