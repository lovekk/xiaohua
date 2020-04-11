<?php
namespace app\xiaohua\controller;

use app\BaseController;
use think\facade\Request;
use think\facade\View;
use think\facade\Db;

use app\xiaohua\model\User as UserModel;
use app\xiaohua\model\UserLog as UserLogModel;

class User extends BaseController
{

    /**
     * 管理员列表
     */
    public function index()
    {
        //渲染模板最常用的是控制器类在继承系统控制器基类（ \think\Controller ）后调用 fetch 方法
        // 不带任何参数 自动定位当前操作的模板文件
        // 查询状态为1的用户数据 并且每页显示10条数据
        $list = UserModel::order('id','desc')->paginate(5);
        // 获取分页显示
        $page = $list->render();

        return view('', ['list' => $list, 'page' => $page]);
    }


    /**
     * 管理员添加视图
     */
    public function userAdd()
    {
        return View::fetch();
    }


    /**
     * 添加管理员方法
     */
    public function addUser()
    {
        $code = 200;
        $username = Request::param('username');
        $password = Request::param('password');

        //$remark = !empty(request('remark')) ? request('remark') : '无备注';
        $remark = Request::param('remark');
        $len = strlen($password);

        if ($username && $len>=4) {
            $created = [
                'username' => $username,
                'password' => $password,
                'remark' => $remark
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
    public function userLog()
    {
        $list = UserLogModel::with(['user'=> function($query) {
            $query->field('id,username');
        }])->order('id','desc')->paginate(2);
        // 获取分页显示
        $page = $list->render();

        return view('', ['list' => $list, 'page' => $page]);
    }
}
