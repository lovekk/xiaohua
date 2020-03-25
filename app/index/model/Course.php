<?php

/**
 * Created by PhpStorm.
 * User: zk
 * Date: 2020/2/21
 * Time: 14:45
 */

namespace app\index\model;
use think\Model;

class Course extends Model
{

    //关联分类外键
    public function classification()
    {
        return $this->belongsTo(Classification::class,'classification_id','id');
    }

}