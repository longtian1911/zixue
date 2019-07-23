<?php
//实例：图像验证码
/*   
	 1、产生随机4位字符串
	 2、创建一个空画布
	 3、分配颜色：背景色，文字颜色
	 4、往图像上写入ttf字符串 
	 5、输出图像，并销毁图像
*/
//产生随机4位的字符串
$arr1 = array_merge(range('A', 'Z'),range(0, 9),range('a', 'z'));
shuffle($arr1); //将数组随机打乱
$arr2 = array_rand($arr1,4); //从数组中随机取出数组下标
//循环数组arr2，取出指定下标对应的元素值
foreach ($arr2 as $index) {
	$str .= $arr1[$index];
}
//创建一个空的画布，并分配颜色
$width = 120;
$height = 40;
$img = imagecreatetruecolor($width, $height);
$color1 = imagecolorallocate($img, mt_rand(0,255), mt_rand(0,200), mt_rand(100,255));

//绘制带填充的矩形
imagefilledrectangle($img, 0, 0, $width, $height, $color1);

//写入一行ttf的字符串，将验证码字符串写入到图像上
$color3 = imagecolorallocate($img, mt_rand(0,255), mt_rand(0,200), mt_rand(100,255));
$fontfile = './123.ttf';
imagettftext($img, 28, 0, 10, 30, $color3, $fontfile, $str);

//绘制200个像素点
for ($i=0; $i < 200; $i++) { 
	$color2 = imagecolorallocate($img, mt_rand(0,255), mt_rand(0,200), mt_rand(100,255));
	imagesetpixel($img, mt_rand(0,$width), mt_rand(0,$height), $color2);
}


header('content-type:image/png');
imagepng($img);
imagedestroy($img);
echo $str;