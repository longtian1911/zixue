<?php
namespace Home\Model;
use \Frame\Libs\BaseModel;
class CategoryModel extends BaseModel{
	protected $table = 'category';

	//获取原始的文章分类连表数据获取分类和分类下文章的数量
	public function fetchAllWithJoin(){
		//构建连表查询的sql语句
		$sql = "SELECT category.*,count(article.id) as article_count FROM {$this->table} ";
		$sql .= "LEFT JOIN article ON category.id = article.category_id ";
		$sql .= "GROUP BY category.id ";
		$sql .= "ORDER BY category.id asc";
		//执行sql语句
		return $this->pdo->fetchAll($sql);
	}
	//获取无限极分类数据,对分类进行无限极分类处理
	public function categoryList($arrs,$level = 0,$pid = 0){
		//参数说明:$arrs 原始分类数据  $level 菜单登记 $pid 上层菜单id值
		//静态变量:一定是在函数中定义的，第一次调用函数式初始化一次，第二次以后不再初始化，静态变量的值，在函数执行完毕后不会消失
		static $categorys = array();
		//循环原始的分类数组
		foreach ($arrs as $arr) {
			//查找下级菜单
			if ($arr['pid'] == $pid) {
				$arr['level'] = $level;
				$categorys[] = $arr;
				//递归调用
				$this->categoryList($arrs,$level+1,$arr['id']);
			}
		}
		//返回结果
		return $categorys;
	}


}