<?php

/**
 * Created by PhpStorm.
 * User: zk
 * Date: 2020/3/21
 * Time: 14:45
 */

namespace app\index\model;
use think\Model;

class Comment extends Model
{
    //关联分类外键
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}