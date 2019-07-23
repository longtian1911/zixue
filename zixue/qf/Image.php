<?php
$image = new Image();
//生成水印图片
//$image->water('1.jpg', '2.png',0,40);
$image->suofang('1.jpg', 100, 1300);
class Image{
    //路径
    protected $path;
    //是否启用随机名字
    protected $isRandName;
    //要保存的图像类型
    protected $type;

    //通过构造方法对成员属性进行初始化
    public function __construct($path = './', $isRandName = true, $type = 'png')
    {
        $this->path = $path;
        $this->isRandName = $isRandName;
        $this->type = $type;
    }
    
    /**
     * @access: 公开的添加水印的方法
     * @Descripttion: 这是一个文件
     * @test: 测试代码
     * @param 参数一：$image:需要添加水印的图片  $water:水印图片 $postion:水印图片的位置 $tmd:水印图片的透明度  $prefix:水印图片的前缀
     * @return: 返回值类型
     */
    public function water($image, $water, $postion, $tmd = 100, $prefix = 'water_'){
        //判断这两个图片是否存在
        if((!file_exists($image)) || (!file_exists($water))){
            die('图片资源不存在');
        }
        //得到需要添加水印图片的宽度和高度以及水印图片的宽度和高度
        $imageInfo = self::getImageInfo($image);
        $waterInfo = self::getImageInfo($water);
        //判断水印图片能否贴上来
        if(!$this->checkImage($imageInfo, $waterInfo)){
            exit('水印图片太大');
        }
        //打开图片
        $imageRes = self::openAnyImage($image);
        $waterRse = self::openAnyImage($water);
        //根据水印图片的位置计算水印图片的坐标
        $pos = $this->getPosition($postion, $imageInfo, $waterInfo);
        //将水印图片贴上去
        imagecopymerge($imageRes, $waterRse, $pos['x'], $pos['y'], 0, 0, $waterInfo['width'], $waterInfo['height'], $tmd);
        //要得到要保存图片的文件名
        $newName = $this->createNewName($image, $prefix);
        //得到保存图片的路径
        $newPath = rtrim($this->path, '/') . '/' .$newName;
        //保存图片
        $this->saveImage($imageRes, $newPath);
        //销毁资源
        imagedestroy($imageRes);
        imagedestroy($waterRse);
        return $newPath;
    }

    //对外公开的缩放方法
    /**
     * @access: public
     * @Descripttion: 缩放图片函数
     * @test: 测试代码
     * @param $image 需要缩放的图片  $width $heigh缩放后的宽度和高度
     * @return: 返回值类型
     */
    public function suofang($image, $width, $heigh, $prefix = 'sf_'){
        //得到图片原来的宽度和高度
        $info = self::getImageInfo($image);
        //根据图片原来的宽高和最终要缩放宽高计算得到的图像不变形的宽高
        $size = $this->getNewSize($width, $heigh, $info);
        //打开图片资源
        $imageRes = self::openAnyImage($image);
        //进行缩放
        $newRes = $this->kidOfImage($imageRes, $size, $info);
        //保存图片
        $newName = $this->createNewName($image, $prefix);
        $newPath = rtrim($this->path, '/') . '/' . $newName;
        $this->saveImage($newRes, $newPath);
        //销毁图像资源
        imagedestroy($imageRes);
        imagedestroy($newRes);
    }

    //保存图像资源函数
    protected function saveImage($imageRes, $newPath){
        //根据需要保存的图片类型来保存
        $func = 'image' . $this->type;
        //通过变量函数进行保存
        $func($imageRes, $newPath);
    }

    //得到文件名函数
    protected function createNewName($imagePath, $prefix){
        if($this->isRandName){
            $name = $prefix . uniqid() . '.' . $this->type;
        }else{
            $name = $prefix . pathinfo($imagePath)['filename'] . '.' . $this->type;
        }
        return $name;
    }

    //根据位置计算水印图片的坐标
    protected function getPosition($postion, $imageInfo, $waterInfo){
        switch($postion){
            case 1:
                $x = 0;
                $y = 0;
                break;
            case 2:
                $x = ($imageInfo['width'] - $waterInfo['width']) / 2;
                $y = 0;
                break;
            case 3:
                $x = $imageInfo['width'] - $waterInfo['width'];
                $y = 0;
                break;
            case 4:
                $x = 0;
                $y = ($imageInfo['height'] - $waterInfo['height']) / 2;
                break;
            case 5:
                $x = ($imageInfo['width'] - $waterInfo['width']) / 2;
                $y = ($imageInfo['height'] - $waterInfo['height']) / 2;
                break;
            case 6:
                $x = $imageInfo['width'] - $waterInfo['width'];
                $y = ($imageInfo['height'] - $waterInfo['height']) / 2;
                break;
            case 7:
                $x = 0;
                $y = $imageInfo['height'] - $waterInfo['height'];
                break;
            case 8:
                $x = ($imageInfo['width'] - $waterInfo['width']) / 2;
                $y = $imageInfo['height'] - $waterInfo['height'];
                break;
            case 9:
                $x = $imageInfo['width'] - $waterInfo['width'];
                $y = $imageInfo['height'] - $waterInfo['height'];
                break;
            case 0:
                $x = mt_rand(0, ($imageInfo['width'] - $waterInfo['width']));
                $y = mt_rand(0, $imageInfo['height'] - $waterInfo['height']);
                break;
        }
        return ['x'=>$x, 'y'=>$y];
    }

    //判断水印图片是否大于原图片
    protected function checkImage($imageInfo, $waterInfo){
        if(($waterInfo['width'] > $imageInfo['width']) || ($waterInfo['height'] > $imageInfo['height'])){
            return false;
        }
        return true;
    }

    //静态方法，根据图片的路径得到图片的信息，宽度 、高度、mime类型
    static public function getImageInfo($imagePath){
        //得到图片信息
        $info = getimagesize($imagePath);
        //保存图片宽度
        $data['width'] = $info[0];
        //保存图像高度
        $data['height'] = $info[1];
        //保存图像mime类型
        $data['mime'] = $info['mime'];
        //将图像信息返回
        return $data;
    }

    //根据图像类型打开任意图片
    public static function openAnyImage($imagePath){
        //得到图像的mime类型
        $mime = self::getImageInfo($imagePath)['mime'];
        //根据不同的mime类型来使用不同的函数打开图像
        switch($mime){
            case 'image/png':
                $image = imagecreatefrompng($imagePath);
                break;
            case 'image/gif':
                $image = imagecreatefromgif($imagePath);
                break;
            case 'image/jpeg':
                $image = imagecreatefromjpeg($imagePath);
                break;
            case 'image/wbmp':
                $image = imagecreatefromwbmp($imagePath);
                break;
        }
        return $image;
    }

    //处理透明色函数
    protected function kidOfImage($srcImg, $size, $imgInfo){
        //传入新的尺寸，创建一个指定尺寸的图片
        $newImg = imagecreatetruecolor($size['old_w'], $size['old_h']);
        //定义透明色 
        $otsc = imagecolortransparent($srcImg);
        if($otsc >= 0){
            //取得透明色
            $transparentcolor = imagecolorsforindex($srcImg, $otsc);
            //创建透明色
            $newtransparentcolor = imagecolorallocate(
                $newImg,
                $transparentcolor['red'],
                $transparentcolor['green'],
                $transparentcolor['blue']
            );
        }else {
            //将黑色作为透明色，因为创建图像后再第一次分配颜色时背景默认为黑色
            $newtransparentcolor = imagecolorallocate($newImg, 0, 0, 0);
        }
        //背景填充透明
        imagefill($newImg, 0, 0, $newtransparentcolor);
        imagecolortransparent($newImg, $newtransparentcolor);
        imagecopyresampled($newImg, $srcImg, $size['x'], $size['y'], 0, 0, $size['new_w'], $size['new_h'], $imgInfo['width'], $imgInfo['height']);
        return $newImg;
    }


    /**
     * @access: public
     * @Descripttion: 计算图片宽度和高度
     * @test: 测试代码
     * @param $width $heigh最终缩放的宽度和高读 $imgInfo 原始图片的宽度和高度
     * @return: 返回值类型
     */    
    protected function getNewSize($width,$height, $imgInfo){
        $size['old_w'] = $width;
        $size['old_h'] = $height;
        $scaleWidth = $width / $imgInfo['width'];
        $scaleHeight = $height / $imgInfo['height'];
        $scaleFinal = min($scaleWidth, $scaleHeight);
        $size['new_w'] = round($imgInfo['width'] * $scaleFinal);
        $size['new_h'] = round($imgInfo['height'] * $scaleFinal);
        if($scaleWidth < $scaleHeight){
            $size['x'] = 0;
            $size['y'] = round(abs($size['new_h'] - $height) / 2);
        }else {
            $size['y'] = 0;
            $size['x'] = round(abs($size['new_w'] - $width) / 2);
        }
        return $size;
    }
}