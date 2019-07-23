<?php
//声明命名空间
namespace Home\Controller;
use \Frame\Libs\BaseController;
use \Home\Model\LinksModel;
use \Home\Model\CategoryModel;
use \Home\Model\ArticleModel;
//定义首页控制器类
final class IndexController extends BaseController{
	//显示首页方法
	public function index(){
		//获取友情链接数据
		$links = LinksModel::getInstance()->fetchAll();

		//获取无限极分类数据
		$categorys = CategoryModel::getInstance()->categoryList(CategoryModel::getInstance()->fetchAllWithJoin());

		//获取文章按月份归档数据
		$moths = ArticleModel::getInstance()->fetchAllWithCount();

		//构建搜索的条件
		$where = "2>1";
		if (!empty($_GET['category_id'])) {
			$where .= " AND category_id=" . $_GET['category_id'];
			$params['category_id'] = $_GET['category_id'];
		}
		if (!empty($_REQUEST['keyword'])) {
			$where .= " AND title LIKE '%" . $_REQUEST['keyword'] ."%'";
			$params['keyword'] = $_REQUEST['keyword'];
		}
		//构建分页参数
		$pagesize = 5;
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$startrow = ($page - 1) * $pagesize;
		$recordes = ArticleModel::getInstance()->rowCount($where);
		$params['c'] = CONTROLLER; 
		$params['a'] = ACTION;
		//获取分页字符串数据
		$pageObj = new \Frame\Vendor\Pager($recordes,$pagesize,$page,$params);
		$pageStr = $pageObj->showPage();
		//获取文章连表查询数据
		$articles = ArticleModel::getInstance()->fetchAllWithJoin($where,$startrow,$pagesize);
		//给前端赋值
		
		$this->smarty->assign(array(
			'links' => $links,
			'category' => $categorys,
			'months' => $moths,
			'articles' => $articles,
			'pageStr' => $pageStr
		));
		$this->smarty->display('index.html');
	}

	//显示列表页面
	public function showList(){
		//获取友情链接数据
		$links = LinksModel::getInstance()->fetchAll();

		//获取无限极分类数据
		$categorys = CategoryModel::getInstance()->categoryList(CategoryModel::getInstance()->fetchAllWithJoin());

		//获取文章按月份归档数据
		$moths = ArticleModel::getInstance()->fetchAllWithCount();

		//构建搜索的条件
		$where = "2>1";
		if (!empty($_GET['category_id'])) {
			$where .= " AND category_id=" . $_GET['category_id'];
			$params['category_id'] = $_GET['category_id'];
		}
		if (!empty($_REQUEST['keyword'])) {
			$where .= " AND title LIKE '%" . $_REQUEST['keyword'] ."%'";
			$params['keyword'] = $_REQUEST['keyword'];
		}
		//构建分页参数
		$pagesize = 30;
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$startrow = ($page - 1) * $pagesize;
		$recordes = ArticleModel::getInstance()->rowCount($where);
		$params['c'] = CONTROLLER; 
		$params['a'] = ACTION;
		//获取分页字符串数据
		$pageObj = new \Frame\Vendor\Pager($recordes,$pagesize,$page,$params);
		$pageStr = $pageObj->showPage();
		//获取文章连表查询数据
		$articles = ArticleModel::getInstance()->fetchAllWithJoin($where,$startrow,$pagesize);
		//给前端赋值
		
		$this->smarty->assign(array(
			'links' => $links,
			'category' => $categorys,
			'months' => $moths,
			'articles' => $articles,
			'pageStr' => $pageStr
		));
		$this->smarty->display('list.html');
	}
}



















