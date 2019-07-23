<?php
/*
	图像验证码：
	(1)产生随机验证码字符串
	(2)创建空画布，并分配颜色
	(3)绘制带填充的矩形
	(4)绘制像素点
	(5)绘制线段
	(6)写入一行TTF字符串
	(7)输出图像，并销毁图像
 */
session_start();

//产生4位随机验证码字符串
$arr1 = array_merge(range('a', 'z'),range(0, 9),range('A', 'Z'));
shuffle($arr1); //打乱数组
$arr2 = array_rand($arr1,4);//随机获取数组的4个下标
foreach ($arr2 as $value) {
	$str .= $arr1[$value];
}
$_SESSION['captcha'] = strtolower($str); //将验证码记录到session中 不区分大小写
//创建一个空画布
$width = 70;
$height = 22;
$img = imagecreatetruecolor($width, $height);
//绘制带填充的矩形
$corlo1 = imagecolorallocate($img, mt_rand(0,200), mt_rand(100,200), mt_rand(0,255));
imagefilledrectangle($img, 0, 0, $width, $height, $corlo1);
//绘制像素点
for ($i=0; $i <=100 ; $i++) { 
	$color2 = imagecolorallocate($img, mt_rand(0,200), mt_rand(100,200), mt_rand(0,255));
	imagesetpixel($img, mt_rand(0,$width), mt_rand(0,$height), $color2);
}
//绘制线段
for ($i=0; $i <=5 ; $i++) { 
	$color2 = imagecolorallocate($img, mt_rand(0,200), mt_rand(100,200), mt_rand(0,255));
	imageline($img, mt_rand(0,$width), mt_rand(0,$height), mt_rand(0,$width), mt_rand(0,$height), $color2);
}
//写入文字
$fontfile = './images/msyh.ttf';
$color3 = imagecolorallocate($img, mt_rand(0,100), mt_rand(0,100), mt_rand(50,150));
imagettftext($img, 18, 0, 5, 20, $color3, $fontfile, $str);
header('content-type:image/png');
imagepng($img);
imagedestroy($img);

