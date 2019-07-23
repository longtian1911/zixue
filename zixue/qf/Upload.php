<?php
/*
 * @Descripttion: 文件上传类
 * @version: 1.0.0
 * @Author: 爱唯主机
 * @link: https://www.aiweiidc.com
 * @Date: 2019-07-20 21:52:20
 * @LastEditors: 爱唯主机
 * @LastEditTime: 2019-07-21 14:16:53
 */

$up = new Upload(['a'=>1]);
$up->uploadFile('fm');
var_dump($up->errorNumber);
var_dump($up->errorInfo);

class Upload
{ 
    protected $path = './upload';//文件上传保存路径
    protected $allowSuffix = ['jpg', 'jpeg' , 'gif', 'wbmp', 'png']; //允许上传文件的后缀
    protected $allowMime = ['image/jpeg', 'image/gif', 'image/wbmp', 'image/png'];//允许的mime类型 
    protected $maxSize = 2000000;//允许上传文件的最大大小
    protected $isRandName = true; //是否启动随机名字
    protected $prefix = 'up_'; //图片前缀
    protected $errorNumber; //上传错误号码
    protected $errorInfo; //上传错误信息
    //上传文件的信息
    protected $oldName;
    protected $suffix; //原始文件后缀
    protected $size;
    protected $mime;
    protected $tmpName;
    //上传后文件的新名字
    protected $newName;

    public function __construct(array $arr = [])
    {
        foreach($arr as $key => $value){
            $this->setOption($key, $value);
        }
    }

    //判断$key是不是我的成员属性，如果是，则设置
    protected function setOption($key, $value){
        //得到所有的成员属性
        //get_class_vars(__CLASS__)获取当前类中所有的成员属性
        $keys = array_keys(get_class_vars(__CLASS__));
        //如果$key是我的成员属性，那么设置值
        if(in_array($key, $keys)){
            $this->$key = $value;
        } 
    }

    //文件上传函数
    //$key 就是你input框中的name属性值
    
    public function uploadFile($key){
        //判断有没有设置路径 path
        if(empty($this->path)){
            $this->setOption('errorNumber', -1);
            return false;
        }
        //判断该路径是否存在，是否可写
        if(!$this->check()){
            $this->setOption('errorNumber', -2);
            return false;
        }

        //判断$_FILES里面的error信息是否为0 如果为0 说明文件信息在服务器端可以直接过去。提取信息保存到成员属性中
        $error = $_FILES[$key]['error'];
        if($error){
            $this->setOption('errorNumber', $error);
            return false;
        }else {
            //提取文件相关信息兵器保存到成员属性中
            $this->getFileInfo($key);
        }

        //判断文件的大小、mime、后缀是否符合
        if(!$this->checkSize() || !$this->checkMime() || !$this->checkSuffix()){
            return false;
        }
        //得到新的文件名字
        $this->newName = $this->createNewName();
        //判断是否是上传文件，并且移动上传文件
        if(is_uploaded_file($this->tmpName)){
            if(move_uploaded_file($this->tmpName, $this->path . '/' . $this->newName)){
                return $this->path . $this->newName;
            }else{
                $this->setOption('errorNumber', -7);
                return false;
            }
        }else {
            $this->setOption('errorNumber', -6);
            return false;
        }
    }

    protected function check(){
        /**
         * @access: public
         * @test: 测试代码
         * @param {type} 参数说明
         * @return: 返回值类型
         */
        //文件夹不存在或者不是目录，则创建文件夹
        if(!file_exists($this->path) || !is_dir($this->path)){
            return mkdir($this->path, 0777, true);
        }

        //判断文件是否可写
        if(!is_writable($this->path)){
            return chmod($this->path, 0777);
        }
        return true;
    }

    protected function getFileInfo($key){
        //得到文件名字
        $this->oldName = $_FILES[$key]['name'];
        //得到文件的mime类型
        $this->mime = $_FILES[$key]['type'];
        //得到文件的临时路径
        $this->tmpName = $_FILES[$key]['tmp_name'];
        //得到文件大小
        $this->size = $_FILES[$key]['size'];
        //得到文件后缀
        $this->suffix = pathinfo($this->oldName)['extension'];
    }

    protected function checkSize(){
        if($this->size > $this->maxSize){
            $this->setOption('errorNumber', -3);
            return false;
        }
        return true;
    }

    protected function checkMime(){
        if(!in_array($this->mime, $this->allowMime)){
            $this->setOption('errorNumber', -4);
            return false;
        }
        return true;
    }

    protected function checkSuffix(){
        if(!in_array($this->suffix, $this->allowSuffix)){
            $this->setOption('errorNumber', -5);
            return false;
        }
        return true;
    }

    //得到新的文件名称
    protected function createNewName(){
        //判断是否启用随机名字
        if($this->isRandName){
            $name = $this->prefix . uniqid() . '.' . $this->suffix;
        }else {
            $name = $this->prefix . $this->oldName;
        }
        return $name;
    }

    //得到文件上传的错误信息
    public function __get($name)
    {
        if($name == 'errorNumber'){
            return $this->errorNumber;
        }elseif ($name == 'errorInfo') {
           return $this->getErrorInfo();
        }
    }

    //叨叨错误信息函数
    protected function getErrorInfo(){
        switch($this->errorNumber){
            case -1:
                $str = '文件路径没有设置';
                break;
            case -2:
                $str = '文件路径不是目录或者没有权限';
                break;
            case -3:
                $str = '文件超过指定大小' . $this->maxSize;
                break;
            case -4:
                $str = '文件mime类型不符合';
                break;
            case -5:
                $str = '文件后缀不符合';
                break;
            case -6:
                $str = '不是上传文件';
                break;
            case -7:
                $str = '文件移动失败';
                break;
            case 1:
                $str = '文件超出php.ini指定大小';
                break;
            case 2:
                $str = '超出html设置大小';
                break;
            case 3:
                $str = '文件只有部分上传';
                break;
            case 4:
                $str = '没有文件上传';
                break;
            case 6:
                $str = '找不到临时文件';
                break;
            case 7:
                $str = '文件写入失败';
                break;
        }
        return $str;
    }
}
