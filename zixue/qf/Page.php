<?php
/*
 * @Descripttion: 这是一个文件
 * @version: 1.0.0
 * @Author: 爱唯主机
 * @link: https://www.aiweiidc.com
 * @Date: 2019-07-20 16:18:51
 * @LastEditors: 爱唯主机
 * @LastEditTime: 2019-07-21 21:58:49
 */

$obj = new Page(5,60);
var_dump($obj->allUrl());
class Page{
    protected $number; //每页显示多少条数据
    protected $totalCount;//一共有多少条数据
    protected $page;//当前页
    protected $totalPage;//总页数
    protected $url; //url

    public function __construct($number, $totalCount)
    {
        $this->number = $number;
        $this->totalCount = $totalCount;
        //得到总页数
        $this->totalPage = $this->getTotalPage();
        //得到当前页数
        $this->page = $this->getPage();
        //得到URL
        $this->url = $this->getUrl();
    }

    protected function getTotalPage(){
        return ceil($this->totalCount / $this->number);
    }

    //得到当前页数
    protected function getPage(){
        if (empty($_GET['page'])) {
            $page = 1;
        }elseif($_GET['page'] > $this->totalPage){
            $page = $this->totalPage;
        }elseif ($_GET['page'] < 1) {
            $page = 1;
        }else{
            $page = $_GET['page'];
        }
        return $page;
    }

    protected function getUrl(){
        //得到协议名
        $scheme = $_SERVER['REQUEST_SCHEME'];
        //得到主机
        $host = $_SERVER['SERVER_NAME'];
        //得到端口号
        $port = $_SERVER['SERVER_PORT'] == 80 ? '' : ':' .$_SERVER['SERVER_PORT'];
        //得到路径和请求的字符串
        $uri = $_SERVER['REQUEST_URI'];
        //中间做处理，要将page = 5等这种字符串拼接到url中，所以如果原来url中有page这个参数，我们首先需要将原来的page参数清空
        //parse_url会php函数将url分成数组，path建对应的?前面的部分，query建对应？后面的部分 例子：http://www.1.com/1.php?a=3
        $uriArray = parse_url($uri);
        $path = $uriArray['path']; 
        if(!empty($uriArray['query'])){
            //首先将请求的字符串变为关联数组
            parse_str($uriArray['query'],$array);
            //清除掉关联数组中的page键值对
            unset($array['page']);
            //将剩下的参数拼接为请求字符串
            $query = http_build_query($array);
            //将请求字符串拼接到路径的后面
            if($query != ''){
                $path = $path . '?' . $query;
            }
        }
        return $scheme . '://' . $host . $port .  $path;
    }

    protected function setUrl(string $str){
        if(strstr($this->url, '?')){
            $url = $this->url . '&' . $str;
        }else {
            $url = $this->url . '?' . $str;
        }
        return $url;
    }

    public function allUrl(){
        return [
            'first' => $this->first(),
            'prev' => $this->prev(),
            'next' => $this->next(),
            'end' => $this->end(),
        ];
    }

    public function first(){
        return $this->setUrl('page=1');
    }

    public function next(){
        //根据当前page得到下一页的页码
        if($this->page + 1 > $this->totalPage){
            $page = $this->totalPage;
        }else {
            $page = $this->page + 1;
        }
        return $this->setUrl('page=' . $page);
    }

    public function prev(){
        //根据当前page得到上一页的页码
        if($this->page - 1 < 1){
            $page = 1;
        }else {
            $page = $this->page - 1;
        }
        return $this->setUrl('page=' . $page);
    }

    public function end(){
        return $this->setUrl('page=' . $this->totalPage);
    }

    public function limit(){
        $offset = ($this->page - 1) * $this->number;
        return $offset . ',' . $this->number;
    }
}