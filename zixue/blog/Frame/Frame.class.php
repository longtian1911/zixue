<?php 
//声明命名空间
namespace Frame;

//定义最终的框架初始化类
final class Frame{
	//定义公共的静态run方法
	public static function run(){
		self::initConfig(); //初始化配置数据
		self::initRoute();  //初始化路由参数
		self::initConst();  //初始化常量定义
		self::initAutoLoad(); //初始化类的自动加载
		self::initDispatch();  //初始化请求分发
	}

	//私有的静态的初始化配置信息
	private static function initConfig(){
		//开启session会话
		session_start();
		$GLOBALS['config'] = require_once(APP_PATH."Conf".DS."Config.php");
	}

	//私有的静态的初始化路由参数
	private static function initRoute(){
		//获取路由参数
		$p = $GLOBALS['config']['default_platform']; //平台参数
		$c = isset($_GET['c']) ? $_GET['c'] : $GLOBALS['config']['default_controller'];
		$a = isset($_GET['a']) ? $_GET['a'] : $GLOBALS['config']['default_action'];
		define("PLAT",$p);
		define("CONTROLLER",$c);
		define("ACTION",$a);
	}

	//私有的静态的常量设置
	private static function initConst()
	{
		define("VIEW_PATH",APP_PATH."View".DS.CONTROLLER.DS); //View目录
	}

	//私有的静态的类的自动加载
	private static function initAutoLoad()
	{
		spl_autoload_register(function($className){
			$filename = ROOT_PATH.str_replace("\\",DS,$className).".class.php";
			//判断类文件是否存在，如果存在，则加载
			if(file_exists($filename)) require_once($filename);
		});
	}

	//私有的静态的分发路由
	private static function initDispatch()
	{
		//构建类的完全路径
		$c = "\\".PLAT."\\Controller\\".CONTROLLER."Controller";

		//创建控制器对象
		$controllerObj = new $c();
		//根据用户不同的动作，调用不同的方法
		$a = ACTION;
		$controllerObj->$a();
	}
}