<?php
namespace app\xiaohua\controller;

use app\BaseController;
use think\facade\Request;
use think\facade\View;

use app\xiaohua\model\Classification as ClassificationModel;
use app\xiaohua\model\User as UserModel;
use app\xiaohua\model\Order as OrderModel;

class Index extends BaseController
{

    // 后台首页框架
    public function index()
    {
        //渲染模板最常用的是控制器类在继承系统控制器基类（ \think\Controller ）后调用 fetch 方法
        // 不带任何参数 自动定位当前操作的模板文件
        $name = '柴小花';
        if (session('?admin_name')){
            $name = session('admin_name');
        }
        // 模板变量赋值
        View::assign('name',$name);
        return View::fetch();
    }


    //后台首页主内容
    public function main()
    {

        //用户数据
        $user_num = UserModel::count('id');
        $user_m_vip = UserModel::where('vip_type',3)->count();
        $user_y_vip = UserModel::where('vip_type',5)->count();
        //vip用户列表
        $user_data = UserModel::where('vip_type','in',[3,5])
            ->limit(10)
            ->order('id','desc')
            ->select();

        //资源数据
        $course_num = ClassificationModel::sum('course_num');
        $download_num = ClassificationModel::sum('download_num');
        $real_down_num = ClassificationModel::sum('real_down_num');


        //订单数据

        View::assign('user_num',$user_num);
        View::assign('user_m_vip',$user_m_vip);
        View::assign('user_y_vip',$user_y_vip);
        View::assign('user_data',$user_data);

        View::assign('course_num',$course_num);
        View::assign('download_num',$download_num);
        View::assign('real_down_num',$real_down_num);

        return View::fetch();
    }
}
