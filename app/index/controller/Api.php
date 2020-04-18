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
use app\index\model\Download as DownloadModel;
use app\index\model\CourseSubmit as CourseSubmitModel;

class Api extends BaseController
{
    //签到逻辑
    public function toSign()
    {
        $msg = ['code' => 100, 'msg' => '初始化！'];
        //先判断是否有用户名
        $user_name = Request::param('user_name');
        $user_id   = Request::param('user_id');
        $mood      = Request::param('mood');
        $ip        = $_SERVER['REMOTE_ADDR'];

        if (!empty($user_name) && !empty($user_id) && !empty($mood)){
            switch ($mood)
            {
                case 1:
                    $des = '非常好';
                    break;
                case 2:
                    $des = '一般';
                    break;
                case 3:
                    $des = '不开心';
                    break;
                case 4:
                    $des = '无所谓';
                    break;
                default:
                    $des = '其他';
            }
            $username = UserModel::where('id','=',$user_id)->value('username');
            if ($user_name == $username){
                //1下载2签到3发布4评论5登录6注册7充值
                //保存用户日志
                $created = [
                    'username' => $user_name,
                    'user_id'  => $user_id,
                    'type'     => '签到',
                    'content'  => $des." ，获得5IT币",
                    'user_ip'  => $ip,
                ];
                $data = UserLogModel::create($created);
                //保存签到
                $mood = [
                    'username' => $user_name,
                    'user_id'  => $user_id,
                    'mood'     => $des,
                    'user_ip'  => $ip,
                    'date'     => date("Y-m-d"),
                ];
                SignModel::create($mood);
                //用户it币+5
//                $user_money = UserModel::find($user_id);
//                $money = $user_money->left_money;
//                $sign_n = $user_money->sign_num;
//                $user_money->left_money = $money + 5;
//                $user_money->sign_num = $sign_n + 1;
//                $user_money->save();
                UserModel::update([
                    'left_money' => Db::raw('left_money+5'),
                    'sign_num'   => Db::raw('sign_num+1')
                ], ['id' => $user_id]);

                //返回成功信息
                $msg = ['code' => 200, 'data' => $data, 'msg' => '签到成功！'];
                return json($msg);

            }else{
                $msg = ['code' => 100, 'msg' => '签到信息不对称！'];
                return json($msg);
            }

        }else{
            $msg = ['code' => 100, 'msg' => '签到信息不完整！'];
            return json($msg);
        }
    }


    //下载课程逻辑
    public function downCourse()
    {
        $msg = ['code' => 100, 'msg' => '初始化！'];
        //先判断是否有用户名
        $user_name = Request::param('user_name');
        $user_id   = Request::param('user_id');
        $c_id      = Request::param('c_id');
        $price     = Request::param('price');
        $ip        = $_SERVER['REMOTE_ADDR'];

        if (!empty($user_name) && !empty($user_id) && !empty($c_id)){
            $userData = UserModel::find($user_id);
            $username = $userData->username;
            $vip_type = $userData->vip_type;  //vip类型 2无 3体验 4年费 5终身
            $left_money = $userData->left_money;
            $vip_end = $userData->vip_end;
            $today = date("Y-m-d");
            //是否可以下载
            $flag = false;
            switch ($vip_type)
            {
                case 5:                //永久vip
                    $flag = true;
                    break;
                case 3:                //月vip
                    if (strtotime($today) <= strtotime($vip_end)){
                        $flag = true;
                    }else{
                        $flag = false;
                    }
                    break;
                case 2:               //无
                    if ($left_money >= $price){
                        $flag = true;
                    }else{
                        $flag = false;
                    }
                    break;
                default:
                    $flag = false;
            }

            if ($user_name == $username && $flag){

                //查询课程
                $cData = CourseModel::find($c_id);
                //课程下载数目
                CourseModel::update([
                    'down_num'      => Db::raw('down_num+1'),
                    'real_down_num' => Db::raw('real_down_num+1')
                ], ['id' => $c_id]);
                //总类下载数目
                $classification_id = $cData->classification_id;
                ClassificationModel::update([
                    'download_num'  => Db::raw('download_num+3'),
                    'real_down_num' => Db::raw('real_down_num+1')
                ], ['id' => $classification_id]);

                //1下载2签到3发布4评论5登录6注册7充值
                //保存用户日志
                $created = [
                    'username'  => $user_name,
                    'user_id'   => $user_id,
                    'type'      => '下载资源',
                    'content'   => $cData->title,
                    'course_id' => $c_id,
                    'user_ip'   => $ip,
                ];
                UserLogModel::create($created);

                //保存下载记录
                $down = [
                    'username'       => $user_name,
                    'user_id'        => $user_id,
                    'course_id'      => $cData->id,
                    'course_title'   => $cData->title,
                    'type'           => $vip_type,
                    'comment'        => $this->getComment(),
                ];
                DownloadModel::create($down);

                //用户下载加1
                $downNum = $userData->down_num;
                $userData->down_num = $downNum + 1;

                //用户使用IT币
                if ($vip_type == 2){
                    $money = $userData->left_money;
                    $userData->left_money = $money - $price;
                }
                $userData->save();

                //返回成功信息
                $msg = ['code' => 200, 'data' => $cData, 'msg' => '下载成功！'];
                return json($msg);

            }else{
                $msg = ['code' => 100, 'msg' => '您的IT币不够，请充值或者办理VIP！'];
                return json($msg);
            }

        }else{
            $msg = ['code' => 100, 'msg' => '数据信息不完整！'];
            return json($msg);
        }
    }


    //评论逻辑
    //不登录不给评论
    function comment()
    {
        $msg = ['code' => 100, 'msg' => '初始化！'];
        //先判断是否有用户名
        $user_name = Request::param('user_name');
        $user_id   = Request::param('user_id');
        $course_id = Request::param('course_id');
        $comment   = Request::param('comment');
        $ip        = $_SERVER['REMOTE_ADDR'];

        if (!empty($user_name) && !empty($user_id) && !empty($comment)){
            //1下载2签到3发布4评论5登录6注册7充值
            //保存用户日志
            $created = [
                'username' => $user_name,
                'user_id'  => $user_id,
                'type'     => '评论',
                'content'  => $comment,
                'user_ip'  => $ip,
            ];
            UserLogModel::create($created);
            //保存到评论表
            $commentData = [
                'user_id'   => $user_id,
                'username'   => $user_name,
                'course_id' => $course_id,
                'content'   => $comment
            ];
            $saveComment = CommentModel::create($commentData);

            //返回成功信息
            $msg = ['code' => 200, 'data' => $saveComment, 'msg' => '签到成功！'];
            return json($msg);


        }else{
            $msg = ['code' => 100, 'msg' => '签到信息不完整！'];
            return json($msg);
        }
    }



    //生成评论内容
    public function getComment(){
        $num = rand(1,10);
        $comment = '感谢分享，已下载！';
        switch ($num)
        {
            case 1:
                $comment = '感谢分享，已下载！';
                break;
            case 2:
                $comment = '我要好好学习了，这么好的资源~';
                break;
            case 3:
                $comment = '支持第一编程网，加油！';
                break;
            case 4:
                $comment = '谢谢分享~';
                break;
            case 5:
                $comment = '支持，支持，越来越好！';
                break;
            case 6:
                $comment = '6666666666666';
                break;
            case 7:
                $comment = '感谢分享，学习中！';
                break;
            case 8:
                $comment = '强烈支持第一编程网~';
                break;
            case 9:
                $comment = '已下载，去学习了！';
                break;
            case 10:
                $comment = '太棒了吧，感谢分享~';
                break;
            default:
                $comment = '感谢分享，已下载！';
        }
        return $comment;
    }


    function linkSubmit()
    {
        $msg = ['code' => 100, 'msg' => '初始化！'];
        //先判断是否有用户名
        $user_name = Request::param('user_name');
        $user_id   = Request::param('user_id');
        $title     = Request::param('title');
        $content   = Request::param('content');
        $baiduyun  = Request::param('baiduyun');
        $type      = Request::param('type');
        $ip        = $_SERVER['REMOTE_ADDR'];

        if (!empty($user_name) && !empty($user_id) && !empty($type)){
            //类型 1链接失效反馈 2VIP用户资源申购 3提交资源 4交流
            switch ($type)
            {
                case 1:
                    //保存用户日志
                    $created = [
                        'username' => $user_name,
                        'user_id'  => $user_id,
                        'type'     => '链接失效反馈',
                        'content'  => $title,
                        'user_ip'  => $ip,
                    ];
                    UserLogModel::create($created);
                    //保存用户提交
                    $submitData = [
                        'username' => $user_name,
                        'user_id'  => $user_id,
                        'type'     => 1,
                        'title'    => $title,
                        'baiduyun' => $baiduyun,
                    ];
                    $submitSave = CourseSubmitModel::create($submitData);
                    //返回成功信息
                    $msg = ['code' => 200, 'data' => $submitSave, 'msg' => '链接失效反馈成功！'];
                    break;
                case 2:
                    //保存用户日志
                    $created = [
                        'username' => $user_name,
                        'user_id'  => $user_id,
                        'type'     => 'VIP用户资源申购',
                        'content'  => '【'.$title.'】——'.$content,
                        'user_ip'  => $ip
                    ];
                    UserLogModel::create($created);
                    //保存用户提交
                    $submitData = [
                        'username' => $user_name,
                        'user_id'  => $user_id,
                        'type'     => 2,
                        'title'    => $title,
                        'content'  => $content
                    ];
                    $submitSave = CourseSubmitModel::create($submitData);
                    //返回成功信息
                    $msg = ['code' => 200, 'data' => $submitSave, 'msg' => 'VIP用户资源申购成功！'];
                    break;
                case 3:
                    //保存用户日志
                    $created = [
                        'username' => $user_name,
                        'user_id'  => $user_id,
                        'type'     => '分享资源',
                        'content'  => '【'.$title.'】——'.$content,
                        'user_ip'  => $ip,
                    ];
                    UserLogModel::create($created);
                    //保存用户提交
                    $submitData = [
                        'username' => $user_name,
                        'user_id'  => $user_id,
                        'type'     => 3,
                        'title'    => $title,
                        'content'  => $content,
                        'baiduyun' => $baiduyun,
                    ];
                    $submitSave = CourseSubmitModel::create($submitData);
                    //返回成功信息
                    $msg = ['code' => 200, 'data' => $submitSave, 'msg' => '提交资源成功！'];
                    break;

                default:
                    $msg = ['code' => 100, 'data' => '', 'msg' => '提交失败！'];
            }

            return json($msg);

        }else{
            $msg = ['code' => 100, 'msg' => '提交信息不完整！'];
            return json($msg);
        }
    }


}
