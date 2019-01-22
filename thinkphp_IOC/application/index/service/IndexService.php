<?php
namespace app\index\service;

use app\container\base\BaseService;

class IndexService extends BaseService
{
    //查询
    public function getAll($data){
        return $this->ioc->objective("IndexModel")->getInfo();
    }
}
