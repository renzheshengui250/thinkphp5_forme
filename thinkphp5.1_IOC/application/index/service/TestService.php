<?php
namespace app\index\service;

use app\container\base\BaseService;

class TestService extends BaseService
{
    public function ha(){
        $this->ioc->objective(['className'=>'TestModel'])->ha();
    }
}