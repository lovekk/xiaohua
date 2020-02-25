<?php
/**
 * Created by PhpStorm.
 * User: zk
 * Date: 2020/2/21
 * Time: 14:45
 */

namespace app\controller\home;

use app\BaseController;
use think\facade\Db;
use app\model\User as UserModel;

class Index extends BaseController
{

    public function index()
    {

        UserModel::select();

        return 'Hello!';
    }

    public function hello($name = 'ThinkPHP6')
    {
        return 'hello,' . $name;
    }
}
