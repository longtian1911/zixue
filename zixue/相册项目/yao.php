<?php 
// echo md5('123456789');
// die();

//创建相册数据库
CREATE DATABASE IF NOT EXISTS `php68` CHARSET utf8;
//创建用户数据表user
CREATE TABLE IF NOT EXISTS `user`(
	`id` int not null auto_increment primary key, #用户id
	`username` varchar(20), #用户名成都为20个字符
	`password` char(32) #密码 md5加密长度为32字符
)ENGINE=InnoDB;
//创建相册数据表photos
CREATE TABLE IF NOT EXISTS `photos`(
	`id` int not null auto_increment primary key, #相册id
	`title` varchar(20),#相片标题
	`imgsrc` varchar(100),#图片路径
	`intro` text,#照片简介
	`hits` int not null default 0, #访问量
	`addate` int(10) #发布时间
)ENGINE=InnoDB;
//添加一条用户数据
INSERT INTO `user`(username,password) VALUES ('admin','25f9e794323b453885f5181f1b624d0b');
