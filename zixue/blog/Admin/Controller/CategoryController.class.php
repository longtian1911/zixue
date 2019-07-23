<?php
//声明命名空间
namespace Admin\Controller;
use Frame\Libs\BaseController;
use \Admin\Model\CategoryModel;
final class CategoryController extends BaseController{
	//显示分类页面
	public function index(){
		$this->denyAccess();
		//获取分类的原始数据
		$category = CategoryModel::getInstance()->fetchAll("id ASC");
		//获取无限极分类数据，将原始分类数据，转成无限极分类数据
		$categorys = CategoryModel::getInstance()->categoryList($category);
		//向视图赋值，并显示视图
		$this->smarty->assign('categorys',$categorys);
		$this->smarty->display('index.html');
	}

	//显示修改页面
	public function edit(){
		$this->denyAccess();
		$this->smarty->display('edit.html');
	}

	//显示添加页面
	public function add(){
		$this->denyAccess();
		//获取无限极分类数据
		$categorys = CategoryModel::getInstance()->categoryList(CategoryModel::getInstance()->fetchAll('id DESC'));
		//向视图赋值，并显示视图
		$this->smarty->assign('categorys',$categorys);
		$this->smarty->display('add.html');
	}

	//插入数据
	public function insert(){
		$this->denyAccess();
		//获取表单提交数据
		$data['classname'] = $_POST['classname'];
		$data['orderby'] = $_POST['orderby'];
		$data['pid'] = $_POST['pid'];
		//判断插入的记录是否成功
		if (CategoryModel::getInstance()->insert($data)) {
			$this->jump("分类添加成功！",'?c=Category');
		}else{
			$this->jump("分类添加失败",'?c=Category');
		}
	}

	//删除记录
	public function delete(){
		$this->denyAccess();
		//获取地址栏传递过来的id
		$id = $_GET['id'];
		//判断是否删除成功
		if (CategoryModel::getInstance()->delete($id)) {
			$this->jump("分类删除成功",'?c=Category');
		}else{
			$this->jump("分类删除失败",'?c=Category');
		}
	}
}








