<?php
namespace app\index\controller;

use app\container\base\BaseController;
use mp3\Mp3file;

class Mp3 extends BaseController
{
    /*
     * 调用类文件获取mp3文件的时长
     */
    public function get()
    {
        /**
         * 获取该mp3的时长
         */
        $mp3_path = "xxxxx.mp3";

        $mp3        = new Mp3file($mp3_path);
        $mp3Data    = $mp3->get_metadata();
        $mp3_length = $mp3Data['Length'];      //MP3的时长（秒）
        echo $mp3_length;
    }
}
