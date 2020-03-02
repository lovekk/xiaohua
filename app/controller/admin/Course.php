<?php
namespace app\controller\admin;

use app\BaseController;
use think\Db;
use think\facade\Request;
use think\facade\View;

use app\model\Course as CourseModel;
use app\model\Classification as ClassificationModel;

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
        $class = Db()::paginate(1);
        // 模板变量赋值
        View::assign('class',$class);
        View::assign([
            'name'  => 'ThinkPHP',
            'email' => 'thinkphp@qq.com'
        ]);
        return View::fetch();
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
