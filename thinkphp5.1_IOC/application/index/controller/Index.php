<?php
namespace app\index\controller;

use app\container\base\BaseController;
use think\Request;

class Index extends BaseController
{
    protected $middleware = ['Check'];

    /**
     * objective();里边的参数是数组
     * ['module'=>'跟命名空间一致的模块名称','className'=>'要跳转到位置的类名称']
     * 如果只有下标为className的元素，默认是跳转到当前的模块中
     */
    public function index()
    {
        $this->ioc->objective(['className'=>"TestService"])->ha();
    }

    public function haha(){
        echo "我是控制器的哈哈方法";
    }
}