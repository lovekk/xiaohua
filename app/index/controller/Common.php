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
use app\index\model\User as UserModel;
use app\index\model\Course as CourseModel;
use app\index\model\Classification as ClassificationModel;
use think\facade\Request;
use think\facade\View;

class Common extends BaseController
{

    //首页
    public function tags()
    {
        //课程
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
        return View::fetch('home/index/course');
    }


    //源码
    public function code()
    {
        return View::fetch();
    }


    //vip
    public function vip()
    {
        return View::fetch();
    }


    //sign
    public function sign()
    {
        return View::fetch();
    }


    //sign
    public function login()
    {
        return View::fetch();
    }

    //sign
    public function register()
    {
        return View::fetch();
    }


}
