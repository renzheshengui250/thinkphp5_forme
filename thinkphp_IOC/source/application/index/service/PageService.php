<?php
namespace app\index\service;

use app\container\base\BaseService;
use think\Db;
use mypage\PageClass;

class PageService extends BaseService
{
    protected $table = "test";
    const pageSize   = 2;               //设置每页显示的条数
    const showPages  = 5;               //设置显示的页数
    /**
     * 调用分页类
     */
    public function getAll($data){
        /*=================================   获取页码信息   =====================================*/
        $page      = @empty($data['page']) ? 1 : $data['page'];        //当前页
        $pageSize  = self::pageSize;                                   //设置显示的页数
        $showPages = self::showPages;                                  //设置每页显示的条数
        $count     = Db::table($this->table)->count();                 //计算分页的总记录数

        /*
         * 实例化分页对象
         * new Page(总记录数,显示页数,当前页码,每页显示条数,[链接]);
         */
        $myPage = new PageClass([
            'count'       => $count,
            'showPages'   => $showPages,
            'currentPage' => $page,
            'pageSize'    => $pageSize
        ]);
        $pageInfo = $myPage->goPage();
        var_dump($pageInfo);die;

        /*=================================   获取待分页的信息数据  =======================================*/

        $pageLimit = ($page - 1) * $pageSize;              //计算偏移量
        $data = Db::table($this->table)
            ->limit($pageLimit,$pageSize)
            ->select();

        die;
        return [
            'pageInfo' => $pageInfo,
            'data'     => $data
        ];
    }
}
