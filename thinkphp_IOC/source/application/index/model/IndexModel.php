<?php
namespace app\index\model;

use app\container\base\BaseModel;

class IndexModel extends BaseModel
{
    //声明表名
    protected $table = "month";

    public function test(){
        echo "我是模型层d";
    }
}
