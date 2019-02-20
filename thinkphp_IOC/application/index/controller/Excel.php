<?php
namespace app\index\controller;

use app\container\base\BaseController;
use aipcont\AipSpeech;
use think\Loader;

class Excel extends BaseController
{
    /**
     * Excel的导入
     * 也可参考：https://blog.csdn.net/weixin_36429334/article/details/72821434
     */
    public function import()
    {
        $file_name = "./static/resource/test.xlsx";

        //自动加载PHPExcel类库
        Loader::import('PHPExcel.Classes.PHPExcel');

        //完成phpExcel导入的功能
        $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
        $objPHPExcel = $objReader->load($file_name, $encode = 'utf-8');

        //判断文件的后缀
        $extension = strtolower(pathinfo($file_name,PATHINFO_EXTENSION) );

        //区分上传文件格式
        if($extension == 'xlsx') {
            $objReader = \PHPExcel_IOFactory::createReader('Excel2007');
            $objPHPExcel = $objReader->load($file_name, $encode = 'utf-8');
        }else if($extension == 'xls'){
            $objReader = \PHPExcel_IOFactory::createReader('Excel5');
            $objPHPExcel = $objReader->load($file_name, $encode = 'utf-8');
        }

        //操作sheet页
        $objSheet = $objPHPExcel->getSheet(0);

        //获取Excel表总行数
        $Rows = $objSheet->getHighestRow();

        //获取Excel表总列数
        $Columns = $objSheet->getHighestColumn();
        //定义空数组
        $data = [];
        for ($i = 1;$i <= $Rows;$i++) {   //从第一行开始
            for ($j="A";$j <= $Columns; $j++) {     //从第一列开始
                $data[$i - 1][] = $objSheet->getCell($j.$i)->getValue();
            }
        }
        //打印获取到的数据
        echo "<pre>";
        var_dump($data);die;

        /**
         * 将这些数据添加入库就完成了Excel内容的导入
         */
    }

    /**
     * Excel的导出
     */
    public function export(){
        //自动加载PHPExcel类库
        Loader::import('PHPExcel.Classes.PHPExcel');

        //实例化  phpexcel类  创建一个Excel表格
        $objPHPExcel = new \PHPExcel();

        //得到sheet页
        $objSheet = $objPHPExcel->getActiveSheet();

        //文件名称
        $filename = "信息统计";

        //设置标题头部
        $objSheet->setCellValue("A1","编号");
        $objSheet->setCellValue("B1","姓名");
        $objSheet->setCellValue("C1","性别");
        $objSheet->setCellValue("D1","年龄");

        //获取数据通过某种方式获取到数据（例如：连接数据库，获取到数据）

        $data = [
            [
                'id'   => 1,
                'name' => "封泽生",
                'sex'  => "男",
                'age'  => 22,
            ],
            [
                'id'   => 2,
                'name' => "鲁智深",
                'sex'  => "男",
                'age'  => 33,
            ],
        ];
        //写入具体数据
        $i = 2;
        foreach ($data as $key => $val){
            $objSheet->setCellValue("A".$i,$val['id']);
            $objSheet->setCellValue("B".$i,$val['name']);
            $objSheet->setCellValue("C".$i,$val['sex']);
            $objSheet->setCellValue("D".$i,$val['age']);
            $i++;
        }

        //设置导出Excel后缀：
        $file_type = "Excel5";

        if($file_type == "Excel5"){
            //输出到浏览器器
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="'.$filename.'.xls"');
            header('Cache-Control: max-age=0');
        }elseif($file_type == "Excel2007"){
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="'.$filename.'.xlsx"');
            header('Cache-Control: max-age=0');
        }

        //写出  保存
        $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel,$file_type);
        $objWriter->save('php://output');
    }
}
