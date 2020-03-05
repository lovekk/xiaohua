<?php
/**
 * Created by PhpStorm.
 * User: zk
 * Date: 2020/2/23
 * Time: 14:26
 */

namespace app\xiaohua\model;
use think\model\concern\SoftDelete;

class Index
{

    use SoftDelete;
    protected $deleteTime = 'delete_time';
}