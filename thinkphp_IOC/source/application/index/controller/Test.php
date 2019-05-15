<?php
namespace app\index\controller;

use app\container\base\BaseController;
use think\Db;
use think\Request;
use think\Route;

class Test extends BaseController
{
    public function index()
    {
        echo "测试";
    }
}
