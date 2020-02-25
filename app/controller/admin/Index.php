<?php
namespace app\controller\admin;

use app\BaseController;
use think\facade\Request;
use think\facade\View;

class Index extends BaseController
{

    public function index()
    {
        //渲染模板最常用的是控制器类在继承系统控制器基类（ \think\Controller ）后调用 fetch 方法
        // 不带任何参数 自动定位当前操作的模板文件
//        Request::
        return View::fetch();
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
