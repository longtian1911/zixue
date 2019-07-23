<?php
$code = new Code();
$code->outImage();
class Code
{
    //验证码个数
    protected $number;
    //验证码类型
    protected $codeType;
    //图像宽度
    protected $width;
    //图像高度
    protected $height;
    //图像资源
    protected $image;
    //验证码字符串
    protected $code;

    public function __construct($number = 4,$codeType = 2,$width = 100,$height = 40){
        //初始化自己的成员属性
        $this->number = $number;
        $this->codeType = $codeType;
        $this->width = $width;
        $this->height = $height;
        //生成验证码函数
        $this->code = $this->createCode();
    }

    //生成验证码函数
    protected function createCode(){
        //通过验证码的类型给你生成不同的验证码
        switch($this->codeType){
            case 0: //纯数字
                $code = $this->getNumberCode();
                break;
            case 1: //纯字母
                $code = $this->getCharCode();
                break;
            case 2: //字母和数字混合
                $code = $this->getNumCharCode();
                break;
            default:
                die('不支持这种验证码类型');
        }
        return $code;
    }

    //生成纯数字的验证码
    protected function getNumberCode(){
        //implode函数式join函数的别名，把数组元素组合为一个字符串
        //range() 函数创建一个包含指定范围的元素的数组。
        $str = implode('',range(0,9));
        //str_shuffle随机地打乱字符串中的所有字符：
        return substr(str_shuffle($str),0,$this->number);
    }

    //生成纯字母的验证码
    protected function getCharCode(){
        $str = implode('',range('a','z'));
        $str .= strtoupper($str); //strtoupper：将字符串转成大写
        return substr(str_shuffle($str), 0, $this->number);

    }

    //生成字符+数字的字符串
    protected function getNumCharCode(){
        $numStr = implode('',range(0,9));
        $str = implode('',range('a','z'));
        $str = $numStr . $str . strtoupper($str);
        return substr(str_shuffle($str),0 ,$this->number);
    }

    //当调用code属性时输出验证码
    public function __get($name)
    {
        if ($name == 'code') {
            return $this->code;
        }
        return false;
    }

    //对象被销毁时销毁图像资源
    public function __destruct()
    {
        imagedestroy($this->image);
    }

    //创建画布
    protected function createImage(){
        $this->image = imagecreatetruecolor($this->width,$this->height);

    }

    //填充背景颜色
    protected function fillBack(){
        imagefill($this->image,0,0,$this->lightColor());
    }

    //随机生成浅色的背景
    protected function lightColor(){
        return imagecolorallocate($this->image, mt_rand(130,255),mt_rand(130,255),mt_rand(130,255));
    }
    
    //随机生成深色的背景
    protected function darkColor(){
        return imagecolorallocate($this->image,mt_rand(0,120),mt_rand(0,120),mt_rand(0,120));
    }
    
    //将验证码画入画布中
    protected function drawChar(){
        $width = ceil($this->width / $this->number);
        for($i = 0; $i < $this->number; $i++){
            $x = mt_rand($i * $width + 5,($i + 1) * $width - 10);
            $y = mt_rand(0, $this->height - 15);
            imagechar($this->image, 30, $x, $y, $this->code[$i], $this->darkColor());
        }
    }

    //输入并且显示验证码
    protected function show(){
        header('Content-type:image/png');
        imagepng($this->image);
    }

    //画干扰元素
    protected function drawDisturb(){
        for($i = 0; $i < 150; $i++){
            $x = mt_rand(0, $this->width);
            $y = mt_rand(0, $this->height);
            imagesetpixel($this->image, $x ,$y ,$this->lightColor());
        }
    }

    //输出验证码
    public function outImage(){
        //创建画布
        $this->createImage();
        //填充背景色
        $this->fillBack();
        //将验证码字符串画到画布中
        $this->drawChar();
        //添加干扰元素
        $this->drawDisturb();
        //输出并且显示
        $this->show();
    }
}

