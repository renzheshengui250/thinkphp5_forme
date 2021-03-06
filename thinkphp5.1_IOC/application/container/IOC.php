<?php
namespace app\container;

class IOC{
    static public $ioc = [];         //定义容器
    static public $className;        //定义实例（对象）名称

    static public $module;    //当前的模块名称（或者说是该文件所对应的命名空间的部分：模块）
    /**
     * 将实例（对象）存入容器
     * @param $className   实例（对象）名称
     * @param $object
     */
    public function set($className,$object){
        self::$ioc[$className] = $object;
    }

    /**
     * 实例（对象）
     * @param $className   获取实例（对象）名称
     * @return mixed
     */
    public function get($className){
        return self::$ioc[$className]($this);
    }

    /**
     * __call       当要调用的方法不存在或权限不足时，会自动调用__call 方法。
     * ------------------------------------------------------------------------
     *
     * $action  实例（对象）中的方法
     * $param   传递的参数
     */
    public function __call($action, $param = "")
    {
        //获取传递的参数
        $arr = empty($param) ? "" : $param[0];
        //获取实例（对象）
        $className = self::$className;

        /**
         * 获取实例（对象）中的方法 且 传递参数
         */
        return $this->get($className)->$action($arr);
    }

    /**
     * objective  操作的目的
     * @param $className   实例（对象）名称
     * @return $this
     */
    public function objective($objectArr = []){
        //获取当前的模块名称
        self::$module = isset($objectArr['module']) ? $objectArr['module'] : request()->module();

        //获取当前的实例（对象）名称
        self::$className  = $className = $objectArr['className'];

        //判断容器中的实例（对象）是否存在
        if(!isset(self::$ioc[$className])){
            //实例对象不存在   ----  工厂中实例化该对象
            $this->set($className, function(&$ioc) use ($className){
                return Factory::$className($ioc);
            });
        }
        return $this;
    }

    /**
     * @return mixed  返回当前要执行到的模块名称
     */
    public function module(){
        return self::$module;
    }
}