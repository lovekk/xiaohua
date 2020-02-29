<?php
/**
 * Created by PhpStorm.
 * User: zk
 * Date: 2020/2/28
 * Time: 14:45
 */

namespace app\controller\home;

use app\BaseController;
use think\facade\Db;
use app\model\User as UserModel;
use think\facade\Request;
use think\facade\View;

class Login extends BaseController
{


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

}
