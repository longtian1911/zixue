<?php
//创建用户表的sql语句
CREATE TABLE IF NOT EXISTS `user`(
	`id` int not null auto_increment primary key,#id
	`username` varchar(20),#用户名
	`password` char(32),#密码
	`name` varchar(12), #真实姓名
	`tel` varchar(15),#联系方式
	`last_login_ip` char(15),#最后登录ip地址
	`last_login_time` int(10),#最后登录时间
	`login_times` int not null default 0, #登录的总次数
	`status` tinyint not null default 1,#账号状态：0 关闭 1正常
	`role` tinyint not null default 0, #角色：0普通管理员 1 超级管理员
	`addate` int(10) #注册时间
)ENGINE=MyISAM;

//创建文字分类数据表category
CREATE TABLE IF NOT EXISTS `category`(
	`id` smallint not null auto_increment primary key, #编号
	`classname` varchar(30),#类别名称
	`orderby` tinyint not null default 0, #排序
	`pid` smallint #父id
)ENGINE=MyISAM;

//创建文章表
CREATE TABLE IF NOT EXISTS `article`(
	`id` int not null auto_increment primary key,#编号
	`category_id` smallint,#文章分类id
	`user_id` smallint,#用户id
	`title` varchar(30),#文章标题
	`content` text,#文章内容
	`orderby` tinyint not null default 0,#排序字段
	`comment_count` int not null default 0,#评论数
	`top` tinyint not null default 0,#是否置顶，1置顶 0不置顶
	`read` int not null default 0,#阅读数
	`praise` int not null default 0, #点赞数
	`addate` int(10)#发布时间
)ENGINE=MyISAM;



















