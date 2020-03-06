<?php

/**
 * Created by PhpStorm.
 * User: zk
 * Date: 2020/2/21
 * Time: 14:45
 */

namespace app\xiaohua\model;
use think\Model;
use think\model\concern\SoftDelete;
class Course extends Model
{

    //设置模型名称
    //protected $name = 'course';
    //设置表名
    //protected $table = '';
    //设置主键
    //protected $pk = 'user_id';  //默认id
    //模型初始化 需要使用static静态方法
    /*
    protected static function init()
    {
        parent::init(); // TODO: Change the autogenerated stub
    }
    */


    use SoftDelete;
    protected $deleteTime = 'delete_time';
    //关联分类外键
    public function classification()
    {
        return $this->belongsTo(Classification::class,'classification_id','id');
    }

}