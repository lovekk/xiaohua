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

class Admin extends Model
{
    use SoftDelete;
    protected $deleteTime = 'delete_time';
}