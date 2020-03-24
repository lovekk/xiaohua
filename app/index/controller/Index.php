<?php
/**
 * Created by PhpStorm.
 * User: zk
 * Date: 2020/2/26
 * Time: 14:45
 */

namespace app\index\controller;

use app\BaseController;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

use app\index\model\User as UserModel;
use app\index\model\Course as CourseModel;
use app\index\model\Classification as ClassificationModel;

/*
 *
 */
class Index extends BaseController
{

    //首页
    public function index()
    {
        //最新

        //热门

        //课程类别
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();
        View::assign('hello',$hello);
        View::assign('ai',$ai);
        View::assign('media',$media);
        return View::fetch();
    }


    //课程
    public function course()
    {
        //查找数据
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();
        View::assign('hello',$hello);
        View::assign('ai',$ai);
        View::assign('media',$media);

        return View::fetch();
    }

    //课程列表
    public function courseList()
    {
        //查找数据
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();
        View::assign('hello',$hello);
        View::assign('ai',$ai);
        View::assign('media',$media);

        return View::fetch();
    }

    //课程列表
    public function courseDetail()
    {
        //查找数据
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();
        View::assign('hello',$hello);
        View::assign('ai',$ai);
        View::assign('media',$media);

        return View::fetch();
    }


    //源码
    public function code()
    {
        //课程类别
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();
        View::assign('hello',$hello);
        View::assign('ai',$ai);
        View::assign('media',$media);
        return View::fetch();
    }


    //vip
    public function vip()
    {
        //课程类别
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();
        View::assign('hello',$hello);
        View::assign('ai',$ai);
        View::assign('media',$media);
        return View::fetch();
    }


    //签到
    public function sign()
    {
        //课程类别
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();
        View::assign('hello',$hello);
        View::assign('ai',$ai);
        View::assign('media',$media);
        return View::fetch();
    }


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


    //个人主页
    public function my()
    {
        //课程类别
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();
        View::assign('hello',$hello);
        View::assign('ai',$ai);
        View::assign('media',$media);
        return View::fetch();
    }

    //关于我们
    public function about()
    {
        //课程类别
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();
        View::assign('hello',$hello);
        View::assign('ai',$ai);
        View::assign('media',$media);
        return View::fetch();
    }


}
