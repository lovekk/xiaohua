<?php
namespace app\xiaohua\controller;

use app\BaseController;

use think\facade\Request;
use think\facade\View;
use think\facade\Db;

use app\xiaohua\model\Course as CourseModel;
use app\xiaohua\model\Classification as ClassificationModel;

class Course extends BaseController
{

    // 课程列表
    public function course()
    {
        //  渲染模板最常用的是控制器类在继承系统控制器基类（ \think\Controller ）后调用 fetch 方法
        // 不带任何参数 自动定位当前操作的模板文件
        return View::fetch();
    }


    // 课程分类
    public function classification()
    {
        // 查询状态为1的用户数据 并且每页显示10条数据
        $list = Db::name('classification')->order('id', 'desc')->paginate(2);

        // 获取分页显示
        $page = $list->render();

        return view('', ['list' => $list, 'page' => $page]);
        // 模板变量赋值
//        View::assign('class',$class);
//        View::assign([
//            'name'  => 'ThinkPHP',
//            'email' => 'thinkphp@qq.com'
//        ]);
//        return View::fetch();
    }


    // 课程评价
    public function comment()
    {
        return View::fetch();
    }


    // 课程用户提交
    public function submit()
    {
        return View::fetch();
    }
}
