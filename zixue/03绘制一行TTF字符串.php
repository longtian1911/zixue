<?php
//创建一个空画布
$img = imagecreatetruecolor(400,100);
//分配颜色
$color1 = imagecolorallocate($img,0,0,0); //黑色
$color2 = imagecolorallocate($img,255,0,0); //红色
//填充背景色
imagefill($img,0,0,$color1);
//往图像上写入一行TTF字体的文本(可以是汉字)
//imagettftext(图像资源,字号大小,旋转角度,X坐标,Y坐标,颜色,字体文件,字符串)
$fontfile = "./123.ttf"; //必须是绝对路径
$str = "欢迎您！";
imagettftext($img,28,0,30,60,$color2,$fontfile,$str);
//输出图像到浏览器
header("Content-Type:image/png");
imagepng($img);
//销毁图像资源
imagedestroy($img);