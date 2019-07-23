<?php
namespace Admin\Controller;
use Frame\Libs\BaseController;
use Admin\Model\LinksModel;
final class LinksController extends BaseController{
	//显示友情链接
	public function index(){
		//权限验证
		$this->denyAccess();
		//获取多行数据
		$links = LinksModel::getInstance()->fetchAll();
		$this->smarty->assign('links',$links);
		$this->smarty->display('index.html');
	}

	//添加友情链接
	public function add(){
		$this->smarty->display('add.html');
	}

	//插入记录
	public function insert(){
		//获取表单数据
		$data['domain'] = $_POST['domain'];
		$data['url'] = $_POST['url'];
		$data['orderby'] = $_POST['orderby'];
		//判断是否写入到数据库
		if (LinksModel::getInstance()->insert($data)) {
			$this->jump('添加成功','?c=Links');
		}else{
			$this->jump('添加失败','?c=Links');
		}
	}
}