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
                    'content'  => $des,
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
        $ip        = $_SERVER['REMOTE_ADDR'];

        if (!empty($user_name) && !empty($user_id) && !empty($c_id)){
            $username = UserModel::where('id','=',$user_id)->value('username');
            if ($user_name == $username){
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
                    'type'      => '下载',
                    'content'   => $cData->title,
                    'course_id' => $c_id,
                    'user_ip'   => $ip,
                ];
                UserLogModel::create($created);

                //返回成功信息
                $msg = ['code' => 200, 'data' => $cData, 'msg' => '下载成功！'];
                return json($msg);

            }else{
                $msg = ['code' => 100, 'msg' => '数据信息不对称！'];
                return json($msg);
            }

        }else{
            $msg = ['code' => 100, 'msg' => '数据信息不完整！'];
            return json($msg);
        }
    }


}
