<?php
namespace mypage;

/**
 * 分页类
 */

class PageClass{
    /** 总条数 */
    protected $count;
    /** 总页数 */
    protected $countPages;
    /** 需要显示的页数 */
    protected $showPage = 10;  
    /** 当前页 */
    protected $currentPage;    
    /** 每页显示条数 */
    protected $pageSize = 10;   
    /** 连接 */     
    protected $href;       
    /** 保存生成的页码 键页码 值为连接 */
    protected $page_arr = [];

    /**
     * __construct  构造函数（获取分页所需参数）
     */ 
    public function __construct($paramArr = []){
        //数据总条数
        $this->count       = $paramArr['count'];
        if(!$this->count){
            return "";
        }
        
        //显示的页码数量
        $this->showPage    = @empty($paramArr['showPage']) ? $this->showPage : $paramArr['showPage'];
        
        //当前页
        $this->currentPage = @empty($paramArr['currentPage']) ? 1 : $paramArr['currentPage'];
        
        //每页显示的条数
        $this->pageSize    = @empty($paramArr['pageSize']) ? $this->pageSize : $paramArr['pageSize'];;

        //分页总数
        $this->countPages  = ceil($this->count / $this->pageSize);

        //判别当前页
        if($this->currentPage >= $this->countPages){
            $this->currentPage = $this->countPages;
        }elseif($this->currentPage <= 1){
            $this->currentPage = 1;
        }
        
        //如果链接没有设置则获取当前连接
        $this->href        = @empty($paramArr['href']) ? htmlentities($_SERVER['PHP_SELF']) : $paramArr['href'];

        /*
         * 创建页码
         */
        $this->construct_Pages();

        /*
         * 开始拼接页码
         */
        return $this->goPage();
    }

    /**
     * @return string正式拼接页码
     */
    public function goPage(){
        return sprintf("<ul>%s %s %s %s %s %s %s </ul>",
            //头部信息拼接
            $this->baseInfo(),
            //首页按钮
            $this->firstPage(),
            //上一页按钮
            $this->prevPage(),
            //按钮拼接
            $this->btnPage(),
            //下一页按钮
            $this->nextPage(),
            //尾页按钮
            $this->lastPage(),
            //跳转页码
            $this->pageJump()
            );
    }

    /**
     * @return  头部信息拼接
     */
    public function baseInfo(){
        return  '<li class="disabled"><span>共' . $this->count . '条记录' . '&nbsp;&nbsp;' . 
            '当前第' . $this->currentPage . ' / ' . $this->countPages . '页</span></li>';
    }

    /**
     * @return 首页按钮
     */
    public function firstPage(){
        return '<li><span><a href="' . $this->href . '?' . http_build_query(['page' => 1]) . '">首页</a> </span></li>';
    }

    /**
     * @return 上一页
     */
    public function prevPage(){
        //如果当前页不是（第一页）就显示（上一页）
        if($this->currentPage > 1){
            $get['page'] = $this->currentPage - 1;
            return '<li><span><a href="' . $this->href . '?' . http_build_query($get) . '">上页</a> </span></li>';
        }
    }

    /**
     * @return 开始页码拼接
     */
    public function btnPage(){
        $pageStr = "";
        foreach ($this->page_arr as $k => $v) {
            //当前页添加背景
            if($k == $this->currentPage){
                $pageStr .= '<li class=\'active\'><span><a href="' . $v . '" style="color:white">' . $k . '</a> </span></li>';
            }else{
                $pageStr .= '<li><span><a href="' . $v . '">' . $k . '</a> </span></li>';
            }
        }
        return $pageStr;
    }

    /**
     * @return 下一页按钮
     */
    public function nextPage(){
        //如果当前页小于（总页数）就显示（下一页）
        if($this->currentPage < $this->countPages){
            $get['page'] = $this->currentPage + 1;
            return '<li><span><a href="' . $this->href . '?' . http_build_query($get) . '">下页</a> </span></li>';
        }
    }

    /**
     * @return 尾页按钮
     */
    public function lastPage(){
        $get['page'] = $this->countPages;
        return '<li><span><a href="' . $this->href . '?' . http_build_query($get) . '">尾页</a> </span></li>';
    }

    /**
     * @return 页码跳转
     */
    public function pageJump(){
        //获取页码跳转的地址
        $current_url = $this->currentPage;
        if(strripos($current_url,"?")){
            //"?"地址中存在：跳转地址为最后一个"/"到"?"的字符
            $action = substr($current_url,(strripos($current_url,"/") + 1),strripos($current_url,"?") - (strripos($current_url,"/") + 1));
        }else{
            //“？”地址中不存在：跳转地址为最后一个“/”到结束的字符
            $action = substr($current_url,(strripos($current_url,"/") + 1));
        }

        return "<li><form action='" . $action . "' method='get'>
        <a style='float:left;margin-left:2px;'>
            <input style='height:27px;width: 60px;border: none;' type='text' class='search-page' name='search-page' placeholder='选择页数'> 
            <input style='height:27px;width: 40px;background: #009688;border: 1px solid #009688;color: white;cursor: pointer;' class='search-btn' type='button' value='确定'> 
        </a></form></li></ul>";
    }
    
    /**
     * construct_Pages 生成页码数组
     * 键为页码，值为链接
     * $this->page_arr=Array(
     *           [1] => wx.php?page=1
     *           [2] => wx.php?page=2
     *           [3] => wx.php?page=3
     *                  ......)
     */
    protected function construct_Pages(){
        //根据当前页计算前后页数
        $leftPage_num  = floor($this->showPage / 2);
//        $rightPage_num = $this->showPage - $leftPage_num;

        //左边显示数为当前页减左边该显示的数
        $left  = $this->currentPage - $leftPage_num;
        $left  = max($left,1);           //左边最小不能小于1
        
        $right = $left + $this->showPage - 1;    //左边加显示页数减1就是右边显示数
        $right = min($right,$this->countPages);  //右边最大不能大于总页数
        
        $left  = max($right - $this->showPage + 1,1); //确定右边再计算左边，必须二次计算

        for ($i = $left; $i <= $right; $i++) {
            $get['page'] = $i;
            $this->page_arr[$i] = $this->href . '?' . http_build_query($get);
        }
    }
}
