<?php
namespace app\index\controller;

use app\container\base\BaseController;
use think\Db;

class Index extends BaseController
{
    public function index()
    {
        /**
         * IndexServiceCont /  IndexModelCont     ----    （S层/M层）的实例（对象）
         * getAll                         ----    （S层/M层）实例（对象）中的方法,传递的参数可以是字符串和数组
         */
        $res = $this->ioc->objective("IndexService")->getAll("sfdfsdfdsf");
    }
}
