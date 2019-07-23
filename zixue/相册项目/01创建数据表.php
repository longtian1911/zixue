<?php


//创建相册数据库php68
CREATE DATABASE IF NOT EXISTS `php68` CHARSET utf8;

//创建用户数据表user
CREATE TABLE IF NOT EXISTS `user`(
`id` int not null auto_increment primary key, #用户ID
`username` varchar(20), #用户名，长度为20个字符
`password` char(32) #密码，长度为32个字符
)ENGINE=InnoDB;

//创建相册数据表photos
CREATE TABLE IF NOT EXISTS `photos`(
`id` int not null auto_increment primary key, #相册ID
`title` varchar(20), #照片标题
`imgsrc` varchar(100), #图像路径
`intro` text, #照片简介
`hits` int not null default 0, #访问量
`addate` int(10) #发布时间
)ENGINE=InnoDB;

//往user表中插入一条记录
INSERT INTO `user`(username,password) VALUES('admin','e10adc3949ba59abbe56e057f20f883e');




