<?php
//定义形状工厂类，生产不同形状对象的工厂
class Factory{
	//公共的静态的创建不同类对象的方法
	public static function getInstance($className){
		//根据传递的不同类目参数，返回不同类对象
		switch ($className) {
			case 'Rectangle':
				return new Rectangle();
				break;
			
			default:
				return null;
				break;
		}
	}
}