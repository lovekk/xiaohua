<?php

/**
 * Created by PhpStorm.
 * User: zk
 * Date: 2020/3/21
 * Time: 14:45
 */

namespace app\xiaohua\model;
use think\Model;
use think\model\concern\SoftDelete;

class Comment extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';

    //关联分类外键
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class,'course_id','id');
    }

}