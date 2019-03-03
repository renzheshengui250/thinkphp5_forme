<?php
namespace app\index\controller;

use app\container\base\BaseController;
use think\Db;

class Index extends BaseController
{
    /**
     * objective();里边的参数是数组
     * ['module'=>'跟命名空间一致的模块名称','className'=>'要跳转到位置的类名称']
     * 如果只有下标为className的元素，默认是跳转到当前的模块中
     *
     * test();  是该跳转到的类中的方法
     */
    public function index()
    {
        $this->ioc->objective(['className'=>"IndexModel"])->test();
    }
}
