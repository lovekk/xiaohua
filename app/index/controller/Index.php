<?php
/**
 * Created by PhpStorm.
 * User: zk
 * Date: 2020/2/26
 * Time: 14:45
 */

namespace app\index\controller;

use app\BaseController;
use app\index\model\UserLog;
use think\facade\Db;
use think\facade\Request;
use think\facade\View;

use app\index\model\User as UserModel;
use app\index\model\UserLog as UserLogModel;
use app\index\model\Course as CourseModel;
use app\index\model\Classification as ClassificationModel;
use app\index\model\Comment as CommentModel;
use app\index\model\Sign as SignModel;

/*
 *
 */
class Index extends BaseController
{

    //首页
    public function index()
    {
        //最新
        $new_course = CourseModel::with(['classification'=> function($query) {
            $query->field('id,name');
        }])->order('id','desc')->limit(10)->select();
        //热门
        $hot_course = CourseModel::with(['classification'=> function($query) {
            $query->field('id,name');
        }])->order('id','desc')->where('down_num','>=',10)->limit(10)->select();
        //课程类别
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();

        View::assign('new_course',$new_course);
        View::assign('hot_course',$hot_course);

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
        $id = Request::param('id');
        //标签
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();
        View::assign('hello',$hello);
        View::assign('ai',$ai);
        View::assign('media',$media);

        return View::fetch();
    }

    //课程详情页
    public function courseDetail()
    {
        $id = Request::param('id');
        //课程详情
        $detail = CourseModel::with(['classification'=> function($query) {
            $query->field('id,name');
        }])->find($id);

        //评论内容
        $comment = CommentModel::with(['user'=> function($query) {
            $query->field('id,username,head_img,vip_type');
        }])->where('course_id','=',$id)->order('id','desc')->select();
        //halt($comment);
        //浏览+1
        //标签
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();
        View::assign('hello',$hello);
        View::assign('ai',$ai);
        View::assign('media',$media);

        View::assign('detail',$detail);
        View::assign('comment',$comment);

        // 获取分页显示
        //$page = $comment->render();
        //View::assign('page',$page);

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


    //签到页面
    public function sign()
    {
        //课程类别
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();
        View::assign('hello',$hello);
        View::assign('ai',$ai);
        View::assign('media',$media);
        View::assign('sign',true);

        $id = session('user_id');
        if ($id){
            $today = date("Y-m-d");
            $username = SignModel::order('id','desc')
                ->where('user_id','=',$id)
                ->where('date','=',$today)
                ->value('username');
            if ($username){
                View::assign('sign',false);
            }
        }
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
        $id = session('user_id');
        $user_data = UserModel::find($id);
        $user_log = UserLogModel::where('user_id','=',$id)->select();

        //课程类别
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();

        View::assign('hello',$hello);
        View::assign('ai',$ai);
        View::assign('media',$media);

        View::assign('user_data',$user_data);
        View::assign('user_log',$user_log);

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



    //搜索search
    public function searchResult(){
        $key_word = Request::param('key_word');

        $search_result = CourseModel::where('title','like','%'.$key_word.'%')->paginate([
            'list_rows'=> 2,
            'query' => request()->param(),
        ]);
        $count = $search_result->total();
        // 获取分页显示
        $page = $search_result->render();
        View::assign('key_word',$key_word);
        View::assign('count',$count);
        View::assign('search_result',$search_result);
        View::assign('page',$page);

        return View::fetch();
    }


}
