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
        foreach($data as $key => $val){
            $this->$key = "$val";
        }
        $this->save();
        //获取外键名称
        $primary_key = $this->primary_key;

        return $this->$primary_key;
    }
}