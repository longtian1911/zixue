<?php
//制作图片水印效果
$filename = './image/timg.jpeg';
$img = imagecreatefromjpeg($filename);
//往图片上写入一行ttf文字
$color = imagecolorallocatealpha($img, 0xff, 0x00, 0x00, 100);//分配半透明颜色 最后一个参数取值是0-127
$fontfile = './123.ttf';
$str = '这是一个风景';
imagettftext($img, 120, 0, 50, 190, $color, $fontfile, $str);
//输出图像并销毁
header('content-type:image/png');
imagepng($img);
imagedestroy($img);