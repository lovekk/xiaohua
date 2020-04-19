<?php
/**
 * Created by PhpStorm.
 * User: zk
 * Date: 2020/2/26
 * Time: 14:45
 */

namespace app\index\controller;

use app\BaseController;
use app\index\model\CourseSubmit;
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
use app\index\model\Download as DownloadModel;
use app\index\model\CourseSubmit as CourseSubmitModel;

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
        }])->order('id','desc')->limit(6)->select();
        //热门
        $hot_course = CourseModel::with(['classification'=> function($query) {
            $query->field('id,name');
        }])->order('id','desc')->where('down_num','>=',50)->limit(6)->select();
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
        //课程类别
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();
        View::assign('hello',$hello);
        View::assign('ai',$ai);
        View::assign('media',$media);
        //侧边栏 最新课程
        $new_course = CourseModel::order('id','desc')->limit(10)->select();
        View::assign('new_course',$new_course);

        return View::fetch();
    }

    //课程列表
    public function courseList()
    {
        //获取分类课程java，C，php
        $id = Request::param('id');
        $data = CourseModel::where('classification_id',$id)->order('id','desc')->paginate(10);
        $page = $data->render();

        View::assign('data',$data);
        View::assign('page',$page);

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
        CourseModel::update([
            'view_num'  => Db::raw('view_num+1')
        ], ['id' => $id]);

        //下载记录前10条
        $download = DownloadModel::with(['user'=> function($query) {
            $query->field('id,username,head_img,vip_type');
        }])->where('course_id','=',$id)->order('id','desc')->limit(6)->select();


        //标签
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();
        View::assign('hello',$hello);
        View::assign('ai',$ai);
        View::assign('media',$media);

        View::assign('detail',$detail);
        View::assign('comment',$comment);

        View::assign('download',$download);

        // 获取分页显示
        //$page = $comment->render();
        //View::assign('page',$page);

        return View::fetch();
    }


    //源码
    public function code()
    {
        //侧边栏 最新课程
        //类型 1视频 2源码 3电子书 4软件 5图文
        $list = CourseModel::with(['classification'=> function($query) {
            $query->field('id,name');
        }])->where('type',2)->order('id','desc')->paginate(12);
        $page = $list->render();
        //侧边栏 最新课程
        //$new_code = CourseModel::where('type',2)->order('id','desc')->limit(10)->select();
        //View::assign('new_code',$new_code);

        View::assign('list',$list);

        View::assign('page',$page);
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
        $user_log = UserLogModel::where('user_id','=',$id)->order('id','desc')->paginate(10);

        //课程类别
        $hello = ClassificationModel::where('type','=',1)->select();
        $ai = ClassificationModel::where('type','=',2)->select();
        $media = ClassificationModel::where('type','=',3)->select();

        View::assign('hello',$hello);
        View::assign('ai',$ai);
        View::assign('media',$media);

        View::assign('user_data',$user_data);
        View::assign('user_log',$user_log);
        // 获取分页显示
        $page = $user_log->render();
        View::assign('page',$page);

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
            'list_rows'=> 10,
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


    //链接失效反馈页面
    public function linkLose(){
        $data = CourseSubmit::where('type',1)->order('id','desc')->paginate(10);
        $page = $data->render();

        View::assign('data',$data);
        View::assign('page',$page);

        return View::fetch();
    }

    //资源求助
    public function linkAsk(){
        $data = CourseSubmit::where('type',2)->order('id','desc')->paginate(10);
        $page = $data->render();

        View::assign('data',$data);
        View::assign('page',$page);

        return View::fetch();
    }

    //链接分享
    public function linkShare(){

        return View::fetch();
    }


}
