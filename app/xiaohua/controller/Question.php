<?php
namespace app\xiaohua\controller;

use app\BaseController;
use think\facade\Request;
use think\facade\View;
use think\facade\Db;

use app\xiaohua\model\Question as QuestionModel;

class Question extends BaseController
{

    /**
     * 管理员列表
     */
    public function index()
    {
        //渲染模板最常用的是控制器类在继承系统控制器基类（ \think\Controller ）后调用 fetch 方法
        // 不带任何参数 自动定位当前操作的模板文件
        // 查询状态为1的用户数据 并且每页显示10条数据
        $list = QuestionModel::paginate(5);
        // 获取分页显示
        $page = $list->render();

        return view('', ['list' => $list, 'page' => $page]);
    }


    /**
     * 管理员添加视图
     */
    public function questionAdd()
    {
        return View::fetch();
    }


    /**
     * 添加问题方法
     */
    public function addQuestion()
    {
        $code = 200;
        $question = Request::param('question');
        $answer = Request::param('answer');

        if ($question) {
            $created = [
                'question' => $question,
                'answer' => $answer,
            ];

            $data = QuestionModel::create($created);
            $code = $data ? 200:404;
        }else{
            $code = 404;
        }
        $msg = ['code' => $code, 'msg' => '添加成功！'];

        return json($msg);
    }


}
