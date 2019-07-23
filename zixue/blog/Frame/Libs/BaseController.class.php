<?php
namespace Frame\Libs;

//定义抽象的基础控制器类
abstract class BaseController{
	//受保护的smarty对象属性
	protected $smarty = null;
	//构造方法
	public function __construct(){
		
		//创建smarty类的对象
		$smarty = new \Frame\Vendor\Smarty();
		//配置smarty的左右定界符
		$smarty->left_delimiter = "<{";
		$smarty->right_delimiter = "}>";
		//制定新的编译目录 sys_get_temp_dir()系统函数，获取操作系统的临时目录
		$smarty->setCompileDir(sys_get_temp_dir().DS.'view_c'.DS);
		//指定视图目录
		$smarty->setTemplateDir(VIEW_PATH);
		$this->smarty = $smarty;
	}

	//跳转方法
	protected function jump($message,$url='?',$time=3){
		echo "<h2>{$message}</h2>";
		header("refresh:{$time};url={$url}");
		die();
	}

	//用户登录判断
	protected function denyAccess(){
		//判断用户是否登录
		if (empty($_SESSION['username'])) {
			$this->jump('请您先登录','?c=User&a=login');
		}
	}
}