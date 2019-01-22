<?php
namespace app\index\controller;

use app\container\base\BaseController;
use aipcont\AipSpeech;
use mp3\Mp3file;

class Baidu extends BaseController
{
    /*
     * 这些东西可以换成自己的
     */
    const APP_ID     = '15292730';
    const API_KEY    = 'm82kXY5zZzQLCCyFV9ZdTYid';
    const SECRET_KEY = 'VCkQRhykGgbnmCCeK6BKWG4ndOf4CC1e';

    /**
     * 利用百度接口：将文字信息转换成MP3
     */
    public function index()
    {
        //生成的MP3在服务器中的位置
        $voice_path = 'voice/voicexxx.mp3';

        /**
         * 判断文件是否存在：
         * （1）存在，不进行处理
         * （2）不存在，直接生成
         */
        if(!file_exists($voice_path)){
            /*
             * 根据语音id，获取语音内容
             */
            $content = "哈哈，你好啊，小伙子哈哈，你好啊，小伙子哈哈，你好啊，小伙子";

            /*
             * 生成APP语音
             */
            $client = new AipSpeech(self::APP_ID, self::API_KEY, self::SECRET_KEY);

            $result = $client->synthesis($content, 'zh', 1, array(
                'vol' => 5,
                'per' => 4,
            ));

            // 识别正确返回语音二进制 错误则返回json 参照下面错误码
            if(!is_array($result)){
                file_put_contents("$voice_path" , $result);

                /*
                 * 调用类文件获取mp3文件的时长
                 */
                $mp3        = new Mp3file($voice_path);

                $mp3Data    = $mp3->get_metadata();
                $mp3_length = $mp3Data['Length'];
                var_dump($mp3_length);
                /*
                 * MP3 的时长和存储位置
                 * 添加入库即可
                 */
            }
        }else{
            $this->error("已经存在,请勿重复操作");
        }
    }
}
