<?php
namespace Admin\Model;
use \Frame\Libs\BaseModel;
final class CategoryModel extends BaseModel{
	protected $table = 'category';

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