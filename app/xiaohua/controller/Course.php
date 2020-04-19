<?php
namespace app\xiaohua\controller;

use app\BaseController;

use app\xiaohua\model\CourseSubmit;
use think\facade\Request;
use think\facade\View;
use think\facade\Db;
use think\facade\Filesystem;

use app\xiaohua\model\Course as CourseModel;
use app\xiaohua\model\Comment as CommentModel;
use app\xiaohua\model\Classification as ClassificationModel;
use app\xiaohua\model\Download as DownloadModel;
use app\xiaohua\model\CourseSubmit as CourseSubmitModel;

class Course extends BaseController
{


    //====================================课程====================================
    /**
     * 课程列表
     */
    public function course()
    {
        //渲染模板最常用的是控制器类在继承系统控制器基类（ \think\Controller ）后调用 fetch 方法
        //不带任何参数 自动定位当前操作的模板文件
        //选择课程分类
        //$list = CourseModel::paginate(2);
        //使用预载入查询解决典型的N+1查询问题
        //上面的代码使用的是IN查询，只会产生2条SQL查询。
        //如果要对关联模型进行约束，可以使用闭包的方式。
        $list = CourseModel::with(['classification'=> function($query) {
            $query->field('id,name');
        }])->order('id','desc')->paginate(30);

        //搜索数据
        $flag = Request::param('flag');
        if ($flag){
            $cond = [];
            $type = Request::param('type');
            $down_num_order = Request::param('down_num');
            $keyword = Request::param('keyword');
            if (!empty($type)) {
                array_push($cond, ["type", "=", intval($type)]);
            }
            if (!empty($keyword)) {
                array_push($cond, ["title",'like', '%'.$keyword.'%']);
            }
            if (!empty($down_num_order)) {
                $list = CourseModel::where($cond)->order("real_down_num",$down_num_order)->paginate([
                    'list_rows'=> 20,
                    'query' => request()->param(),
                ]);
            }else{
                $list = CourseModel::where($cond)->paginate([
                    'list_rows'=> 20,
                    'query' => request()->param(),
                ]);
            }
        }

        // 获取分页显示
        $page = $list->render();
        return view('', ['list' => $list, 'page' => $page]);
    }


    /**
     * 添加课程视图
     */
    public function courseAdd()
    {
        //选择课程分类
        $data = ClassificationModel::select();
        // 模板变量赋值
        View::assign('data',$data);
        return View::fetch();
    }


    /**
     * 添加课程方法
     */
    public function addCourse()
    {
        $code = 200;
        $name = Request::param('name');
        $type = Request::param('type');
        $classification_id = Request::param('classification_id');
        $title = Request::param('title');
        $content = Request::param('content');
        $baiduyun = Request::param('baiduyun');
        $rar_password = Request::param('rar_password');
        $price = Request::param('price');
        $view_num = Request::param('view_num');
        $down_num = Request::param('down_num');
        $comment_num = Request::param('comment_num');
        //1视频 2源码 3电子书 4软件 5图文

        switch ($type)
        {
            case 1:
                $des = '视频';
                break;
            case 2:
                $des = '源码';
                break;
            case 3:
                $des = '电子书';
                break;
            case 4:
                $des = '软件';
                break;
            case 5:
                $des = '图文';
                break;
            default:
                $des = '其他';
        }
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('img');
        if ($file){
            // 上传到本地服务器
            $save_name = Filesystem::disk('public')->putFile( 'img', $file);
            $created = [
                'name' => $name,
                'type' => $type,
                'des' => $des,
                'class' => 1,
                'classification_id' => $classification_id,
                'title' => $title,
                'content' => $content,
                'img' => $save_name,
                'baiduyun' => $baiduyun,
                'rar_password' => $rar_password,
                'price' => $price,
                'view_num' => $view_num,
                'down_num' => $down_num,
                'comment_num' => $comment_num,
            ];
        }else{
            $created = [
                'name' => $name,
                'type' => $type,
                'des' => $des,
                'class' => 1,
                'classification_id' => $classification_id,
                'title' => $title,
                'content' => $content,
                'baiduyun' => $baiduyun,
                'rar_password' => $rar_password,
                'price' => $price,
                'view_num' => $view_num,
                'down_num' => $down_num,
                'comment_num' => $comment_num,
            ];
        }

        $data = CourseModel::create($created);
        $code = $data ? 200:404;
        $msg = ['code' => $code, 'msg' => '添加成功！'];

        ClassificationModel::update([
            'course_num' => Db::raw('course_num+1')
        ], ['id' => $classification_id]);

        return json($msg);
    }


    /**
     * 修改课程视图
     */
    public function courseUpdate()
    {
        //获取ID
        $id = Request::param('id');
        //查找数据
        $data = CourseModel::find(intval($id));
        //选择课程分类
        $classification = ClassificationModel::select();
        // 模板变量赋值
        View::assign('classification',$classification);
        View::assign('data',$data);
        View::assign('id',$id);
        return View::fetch();
    }


    /**
     * 修改课程方法
     */
    public function updateCourse()
    {

        $code = 100;
        $id = Request::param('id');
        $type = Request::param('type');
        $classification_id = Request::param('classification_id');
        $title = Request::param('title');
        $content = Request::param('content');
        $baiduyun = Request::param('baiduyun');
        $rar_password = Request::param('rar_password');
        $price = Request::param('price');
        $view_num = Request::param('view_num');
        $down_num = Request::param('down_num');
        $comment_num = Request::param('comment_num');

        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('img');

        $data = CourseModel::find(intval($id));
        $data->title = $title;
        $data->baiduyun = $baiduyun;
        $data->rar_password = $rar_password;
        $data->price = $price;
        $data->view_num = $view_num;
        $data->down_num = $down_num;
        $data->comment_num = $comment_num;

        if ($file){
            // 上传到本地服务器
            $save_name = Filesystem::disk('public')->putFile( 'img', $file);
            $data->img = $save_name;
        }
        if ($type){
            //1视频 2源码 3电子书 4软件 5图文
            switch ($type)
            {
                case 1:
                    $des = '视频';
                    break;
                case 2:
                    $des = '源码';
                    break;
                case 3:
                    $des = '电子书';
                    break;
                case 4:
                    $des = '软件';
                    break;
                case 5:
                    $des = '图文';
                    break;
                default:
                    $des = '其他';
            }
            $data->type = $type;
        }
        if ($classification_id){
            $data->classification_id = $classification_id;
        }
        if (!empty($content)){
            $data->content = $content;
        }
        $data->save();

        $code = $data ? 200:404;
        $msg = ['code' => $code, 'msg' => '修改成功！'];

        return json($msg);
    }



    //====================================课程分类====================================
    /**
     * 课程分类列表
     */
    public function classification()
    {
        // 查询状态为1的用户数据 并且每页显示10条数据
        //$list = Db::name('classification')->order('id', 'desc')->paginate(5);
        $list = ClassificationModel::paginate(20);
        // 获取分页显示
        $page = $list->render();

        return view('', ['list' => $list, 'page' => $page]);
    }


    /**
     * 添加分类视图
     */
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
        $type = Request::param('type');
        $course_num = Request::param('course_num');
        $download_num = Request::param('download_num');
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('img');
        if ($file){
            // 上传到本地服务器
            $save_name = Filesystem::disk('public')->putFile( 'img', $file);
            $created = [
                'name' => $name,
                'description' => $description,
                'type' => $type,
                'img' => $save_name,
                'course_num' => $course_num,
                'download_num' => $download_num,
            ];
        }else{
            $created = [
                'name' => $name,
                'description' => $description,
                'type' => $type,
                'course_num' => $course_num,
                'download_num' => $download_num,
            ];
        }
        $data = ClassificationModel::create($created);
        $code = $data ? 200:404;


        $msg = ['code' => $code, 'msg' => '添加成功！'];

        return json($msg);
    }


    /**
     * 修改课程分类视图
     */
    public function classificationUpdate()
    {
        //获取ID
        $id = Request::param('id');
        //查找数据
        $data = ClassificationModel::find(intval($id));
        View::assign('data',$data);
        View::assign('id',$id);
        return View::fetch();
    }


    /**
     * 修改课程分类方法
     */
    public function updateClassification()
    {

        $code = 200;
        $id = Request::param('id');
        $name = Request::param('name');
        $description = Request::param('description');
        $type = Request::param('type');
        $course_num = Request::param('course_num');
        $download_num = Request::param('download_num');
        // 获取表单上传文件 例如上传了001.jpg
        $file = request()->file('img');

//        $data = Db::name('classification')
//            ->where('id', intval($id))
//            ->data([
//                'name' => $name,
//                'description' => $description,
//                'course_num' => $course_num,
//                'download_num' => $download_num,
//                ])
//            ->update();

        //自动时间需要用模型来做
        //默认的创建时间字段为create_time，
        //更新时间字段为update_time，
        //支持的字段类型包括timestamp/datetime/int。
        $data = ClassificationModel::find(intval($id));
        $data->name = $name;
        $data->description = $description;
        $data->type = $type;
        $data->course_num = $course_num;
        $data->download_num = $download_num;
        if ($file){
            // 上传到本地服务器
            $save_name = Filesystem::disk('public')->putFile( 'img', $file);
            $data->img = $save_name;
        }
        $data->save();


        $code = $data ? 200:404;
        $msg = ['code' => $code, 'msg' => '修改成功！'];

        return json($msg);
    }


    /**
     * 删除分类
     */
    public function delClassification()
    {
        //获取ID
        $id = Request::param('id');
        //软删除
        //真删吧，paginate只能用Db，软删除要用Model，冲突
        //Model也可以用paginate()
        $data = ClassificationModel::destroy($id);
        // 软删除数据 使用delete_time字段标记删除
        /*
        $data = Db::name('classification')
            ->where('id', $id)
            ->useSoftDelete('delete_time',time())
            ->delete();
        */
        $code = $data ? 200:404;
        $msg = ['code' => $code, 'msg' => '删除成功！'];

        return json($msg);
    }


    //====================================课程评价====================================
    /**
     * 课程评价
     */
    public function comment()
    {
        $list = CommentModel::with(
            [
                'user'=> function($query) {$query->field('id,username');},
                'course'=> function($query) {$query->field('id,title');
        }])->order('id','desc')->paginate(30);
        // 获取分页显示
        $page = $list->render();

        return view('', ['list' => $list, 'page' => $page]);
    }


    /**
     * 删除评价
     */
    public function delComment()
    {
        //获取ID
        $id = Request::param('id');
        //软删除
        $data = CommentModel::destroy($id);
        $code = $data ? 200:404;
        $msg = ['code' => $code, 'msg' => '删除成功！'];

        return json($msg);
    }



    //====================================课程提交====================================
    /**
     * 课程用户提交
     */
    public function courseUp()
    {
        return View::fetch();
    }



    //====================================课程下载====================================
    /**
     * 课程下载列表
*/
    public function download()
    {
        $list = DownloadModel::order('id','desc')->paginate(50);
        // 获取分页显示
        $page = $list->render();
        return view('', ['list' => $list, 'page' => $page]);
    }



    //链接失效反馈页面
    public function linkLose(){
        $data = CourseSubmitModel::where('type',1)->order('id','desc')->paginate(20);
        $page = $data->render();

        View::assign('data',$data);
        View::assign('page',$page);

        return View::fetch();
    }

    //资源求助
    public function linkAsk(){
        $data = CourseSubmitModel::where('type',2)->order('id','desc')->paginate(20);
        $page = $data->render();

        View::assign('data',$data);
        View::assign('page',$page);

        return View::fetch();
    }

    //链接分享
    public function linkShare(){
        $data = CourseSubmitModel::where('type',3)->order('id','desc')->paginate(20);
        $page = $data->render();

        View::assign('data',$data);
        View::assign('page',$page);

        return View::fetch();
    }

    //确认申购、反馈修复
    function linkSubmit()
    {
        $msg = ['code' => 100, 'msg' => '初始化！'];
        //先判断是否有用户名
        $id = Request::param('id');

        if (!empty($id)){
            $data = CourseSubmitModel::find($id);
            $data->is_up = 2;
            $save = $data->save();

            //返回成功信息
            $msg = ['code' => 200, 'data' => $save, 'msg' => '确认成功！'];
            return json($msg);

        }else{
            $msg = ['code' => 100, 'msg' => '信息不完整！'];
            return json($msg);
        }
    }
}
