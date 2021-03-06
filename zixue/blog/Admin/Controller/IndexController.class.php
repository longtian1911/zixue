<?php
//声明命名空间
namespace Admin\Controller;
use Frame\Libs\BaseController;
//定义首页控制器类,并继承基础控制器类
final class IndexController extends BaseController{
	//首页显示
	public function index(){
		//权限验证
		$this->denyAccess();
		$this->smarty->display('index.html');
	}

	//显示顶部框架
	public function top(){
		//权限验证
		$this->denyAccess();
		$this->smarty->display('top.html');
	}

	//显示首页左侧框架
	public function left(){
		//权限验证
		$this->denyAccess();
		$this->smarty->display('left.html');
	}

	//显示首页主题内容
	public function main(){
		//权限验证
		$this->denyAccess();
		$this->smarty->display('main.html');
	}

	//显示首页中间内容
	public function center(){
		//权限验证
		$this->denyAccess();
		$this->smarty->display('center.html');
	}
}