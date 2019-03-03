<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use think\Route;

Route::get([
    'back'      => 'index/index/index',
    'yuyin'     => 'index/baidu/wx',
    'page'      => 'index/page/page',
    'excel_in'  => 'index/excel/import',
    'excel_out' => 'index/excel/export',
]);
