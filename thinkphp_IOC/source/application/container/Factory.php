<?php
namespace app\container;

class Factory{

    /**
     *  工厂主要负责实例化类
     * $class   -----   实例（对象）名称
     * $param   -----   该IOC容器
     */

    static public function __callStatic($class, $param) {
        //获取当前的操作所要执行的模块名称
        $module = (new IOC())->module();
        //获取方法的最后一个单词
        $type = self::getLastWord($class);

        //定义命名空间
        $namespace = '';
        switch ($type) {
            case 'Model':
                //实例化该模型类
                $namespace = "\\app\\$module\\model\\$class";
                return new $namespace();
            case 'Service':
                $namespace = "\\app\\$module\\service\\$class";
                return new $namespace(array_shift($param));
            default:
                echo ('method not exist:');die;
        }

    }

    /**
     * @param $str           传入的字符串
     * @return bool|string   返回截取的最后一个单词
     */
    static private function getLastWord($str) {
        $i = strlen($str) - 1;
        while ($i >= 0 and ( $str[$i] < 'A' or $str[$i] > 'Z')) {
            $i--;
        }

        return mb_substr($str, $i);
    }
}