<?php
//制作图像缩略图
//创建画布：目标画布，原画布
$filename = './image/timg.jpeg';
$src_img = imagecreatefromjpeg($filename); //原画布
$src_w = imagesx($src_img); //原画布的宽度
$src_h = imagesy($src_img); //原画布的高度

$dst_w = $src_w * 0.2; //目标画布的宽度，后面的0.2说明缩小多少倍
$dst_h = $src_h * 0.2; //目标画布的高度
$dst_img = imagecreatetruecolor($dst_w, $dst_h); //目标画布
//生成缩略图
imagecopyresampled($dst_img, $src_img, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
//保存图像，并销毁图像
imagejpeg($dst_img,'./image/01.jpg');
imagedestroy($dst_img);
imagedestroy($src_img);