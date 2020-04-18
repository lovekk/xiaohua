<?php

/**
 * Created by PhpStorm.
 * User: zk
 * Date: 2020/2/21
 * Time: 14:45
 */

namespace app\index\model;
use think\Model;

class Download extends Model
{

    //关联分类外键
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

}