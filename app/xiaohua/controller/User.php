<?php
namespace app\xiaohua\controller;

use app\BaseController;
use app\xiaohua\model\UserLog;
use think\facade\Request;
use think\facade\View;
use think\facade\Db;

use app\xiaohua\model\User as UserModel;
use app\xiaohua\model\UserLog as UserLogModel;

class User extends BaseController
{

    /**
     * 用户列表
     */
    public function index()
    {
        //渲染模板最常用的是控制器类在继承系统控制器基类（ \think\Controller ）后调用 fetch 方法
        // 不带任何参数 自动定位当前操作的模板文件
        // 查询状态为1的用户数据 并且每页显示10条数据
        //默认数据
        $list = UserModel::order('id','desc')->paginate(30);

        //搜索数据
        $flag = Request::param('flag');
        if ($flag){
            $cond = [];
            $vip_type = Request::param('vip_type');
            $keyword = Request::param('keyword');
            if (!empty($vip_type)) {
                array_push($cond, ["vip_type", "=", $vip_type]);
            }
            if (!empty($keyword)) {
                array_push($cond, ["id|username", "=", $keyword]);
            }
            $list = UserModel::where($cond)->order("down_num","desc")->paginate([
                'list_rows'=> 20,
                'query' => request()->param(),
            ]);
        }

        // 获取分页显示
        $page = $list->render();

        return view('', ['list' => $list, 'page' => $page]);
    }


    /**
     * 用户添加视图
     */
    public function userAdd()
    {
        return View::fetch();
    }


    /**
     * 添加用户方法
     */
    public function addUser()
    {
        $code = 200;
        $username = Request::param('username');
        $password = Request::param('password');
        $len = strlen($password);
        if ($username && $len>=4) {
            $num = rand(1,20);
            $created = [
                'username' => $username,
                'password' => $password,
                'head_img'   => 'img/20200202\\'.$num.'.jpg'
            ];

            $data = UserModel::create($created);
            $code = $data ? 200:404;
        }else{
            $code = 404;
        }
        $msg = ['code' => $code, 'msg' => '添加用户成功！'];

        return json($msg);
    }


    /**
     * 用户详情
     */
    public function userDetail()
    {
        $id = Request::param('id');
        $data = UserModel::find($id);
        View::assign('data',$data);
        return View::fetch();
    }


    /**
     * 用户日志
     */
    public function userLog()
    {
        $list = UserLogModel::order('id','desc')->paginate(50);

        //搜索数据
        $keyword = Request::param('keyword');
        if (!empty($keyword)){
            $list = UserLogModel::where("username|user_id|type", "=", $keyword)->order("id","desc")->paginate([
                'list_rows'=> 20,
                'query' => request()->param(),
            ]);
        }

        // 获取分页显示
        $page = $list->render();
        View::assign('list',$list);
        View::assign('page',$page);

        return View::fetch();
    }

    /**
     * 后台为用户充值，办理VIP
     */
    public function changeUser()
    {
        $user_id    = Request::param('user_id');
        $username   = Request::param('username');
        $left_money = Request::param('left_money');

        if ($user_id && $left_money) {
            //保存用户日志
            $created = [
                'username' => $username,
                'user_id'  => $user_id,
                'type'     => '系统操作',
                'content'  => "后台为您增加了：".$left_money."IT币",
                'user_ip'  => '1.1.1.1',
            ];
            $data = UserLogModel::create($created);

            $userData = UserModel::find($user_id);
            //修改用户数据
            if ($left_money == 1029){
                $userData->vip_type = 5;
                $userData->invest_money = 10086;
            }else{
                $userLeft = $userData->left_money;
                $userData->left_money = $userLeft + $left_money;
            }
            $changeM = $userData->save();
            if ($changeM){
                $msg = ['code' => 200, 'data' => $data, 'msg' => '办理成功！'];
            }else{
                $msg = ['code' => 100, 'msg' => '数据存在错误！'];
            }
            return json($msg);

        }else{
            $msg = ['code' => 100, 'msg' => '数据存在错误！'];
            return json($msg);
        }



    }
}
