<?php
class Start{
	//用来保存自动加载对象
	static public $auto;

	//启动方法，即创建自动加载对象方法
	static public function init(){
		self::$auto = new Psr4AutoLoad();
	}

	//路由方法
	static public function router(){
		//从url中获取要执行的是哪个控制器中的那个方法
		$c = $_GET['c'] ? $_GET['c'] : 'index';
		$a = $_GET['a'] ? $_GET['a'] : 'index';

		//将index处理
		$c = ucfirst(strtolower($c));
		//拼接带有命名空间的类名
		$controller = 'controller\\' . $c . 'Controller';
		//创建对象并且执行对应的方法
		$obj = new $controller();
		call_user_func([$obj, $a]);
	}
}
Start::init();