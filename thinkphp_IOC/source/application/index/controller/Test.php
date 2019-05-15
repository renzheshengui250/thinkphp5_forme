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
        echo "新封泽生1111";
    }

    public function __construct(\app\container\IOC $ioc)
    {
        parent::__construct($ioc);
    }
}
