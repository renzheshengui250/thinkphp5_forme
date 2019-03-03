<?php
namespace app\index\controller;

use app\container\base\BaseController;
use think\Db;
use think\Request;
use think\Route;

class Page extends BaseController
{
    public function page()
    {
        $this->ioc->objective("PageService")->getAll(Request::instance()->get());
    }
}
