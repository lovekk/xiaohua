<?php
namespace app\xiaohua\controller;

use app\BaseController;
use think\facade\Request;
use think\facade\View;
use think\facade\Db;

use app\xiaohua\model\Admin as AdminModel;
use app\xiaohua\model\AdminLog as AdminLogModel;

class Admin extends BaseController
{

    /**
     * 管理员列表
     */
    public function index()
    {
        //渲染模板最常用的是控制器类在继承系统控制器基类（ \think\Controller ）后调用 fetch 方法
        // 不带任何参数 自动定位当前操作的模板文件
        // 查询状态为1的用户数据 并且每页显示10条数据
        //$list = Db::name('admin')->paginate(5);
        $list = AdminModel::paginate(5);
        // 获取分页显示
        $page = $list->render();


        return view('', ['list' => $list, 'page' => $page]);
    }


    /**
     * 管理员添加视图
     */
    public function adminAdd()
    {
        return View::fetch();
    }


    /**
     * 添加管理员方法
     */
    public function addAdmin()
    {
        $code = 200;
        $username = Request::param('username');
        $password = Request::param('password');

        //$remark = !empty(request('remark')) ? request('remark') : '无备注';
        $remark = Request::param('remark');
        $sex = Request::param('sex');
        $len = strlen($password);

        if ($username && $len>=4) {
            $created = [
                'username' => $username,
                'password' => $password,
                'remark' => $remark,
                'sex' => $sex
            ];

            $data = AdminModel::create($created);
            $code = $data ? 200:404;
        }else{
            $code = 404;
        }
        $msg = ['code' => $code, 'msg' => '添加成功！'];

        return json($msg);
    }


    /**
     * 管理员登录日志
     */
    public function adminLog()
    {
        $list = AdminLogModel::order('id','desc')->paginate(20);
        // 获取分页显示
        $page = $list->render();

        return view('', ['list' => $list, 'page' => $page]);
    }
}
