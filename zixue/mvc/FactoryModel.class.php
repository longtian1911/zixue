<?php
//包含所有的模型类
require_once "./StudentModel.class.php";
require_once "./NewsModel.class.php";

//定义最终的工厂模型类
//主要用来生产不同模型类的对象
final FactoryModel
{
	//公共的静态的创建不同模型类对象的方法
	public static function getInstance($modelClassName){
		//创建制定模型类对象，并返回
		return new $modelClassName();
	}
}