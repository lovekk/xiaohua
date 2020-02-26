<?php
/**
 * Created by PhpStorm.
 * User: zk
 * Date: 2020/2/26
 * Time: 14:45
 */

namespace app\controller\home;

use app\BaseController;
use think\facade\Db;
use app\model\User as UserModel;
use think\facade\Request;
use think\facade\View;

class Common extends BaseController
{

    //首页
    public function index()
    {
        return View::fetch();
    }


    //课程
    public function course()
    {
        return View::fetch('home/index/course');
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


    //sign
    public function sign()
    {
        return View::fetch();
    }


    //sign
    public function login()
    {
        return View::fetch();
    }

    //sign
    public function register()
    {
        return View::fetch();
    }


}
