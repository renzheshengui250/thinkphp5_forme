<?php
namespace app\container\base;

use think\Controller;

class BaseController extends Controller
{
    protected $ioc;

    /**
     * 创建该容器
     * Base constructor.
     * @param \app\container\IOC $ioc     容器
     */
    public function __construct(\app\container\IOC $ioc)
    {
        $this->ioc = $ioc;
    }
}