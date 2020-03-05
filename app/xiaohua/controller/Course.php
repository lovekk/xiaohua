<?php
namespace app\xiaohua\controller;

use app\BaseController;

use think\facade\Request;
use think\facade\View;
use think\facade\Db;
use think\facade\Filesystem;

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


    /**
     * 课程分类列表
     */
    public function classification()
    {
        // 查询状态为1的用户数据 并且每页显示10条数据
        $list = Db::name('classification')->order('id', 'desc')->paginate(2);
        // 获取分页显示
        $page = $list->render();

        return view('', ['list' => $list, 'page' => $page]);
        // 模板变量赋值
    }


    //添加视图
    public function classificationAdd()
    {
        return View::fetch();
    }


    /**
     * 添加课程分类方法
     */
    public function addClassification()
    {

        $code = 200;
        $name = Request::param('name');
        $description = Request::param('description');
        $course_num = Request::param('course_num');
        $download_num = Request::param('download_num');
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('img');
        // 上传到本地服务器
        $save_name = Filesystem::disk('public')->putFile( 'img', $file);

        $created = [
            'name' => $name,
            'description' => $description,
            'img' => $save_name,
            'course_num' => $course_num,
            'download_num' => $download_num,
        ];

        $data = ClassificationModel::create($created);
        $code = $data ? 200:404;
        $msg = ['code' => $code, 'msg' => '添加成功！'];

        return json($msg);
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
