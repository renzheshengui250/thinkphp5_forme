<?php
namespace app\container\base;

use think\Model;
use think\Db;

class BaseModel extends Model
{
    /**
     * base实现  所有模型中基本的增删改查
     */

    //添加
    public function addInfo($data){
        return $this->insert($data);
    }

    //查询
    public function getInfo(){
        return Db::table($this->table)->select();
    }

    //. . . . . .
}