<?php
namespace Admin\Model;
use \Frame\Libs\BaseModel;
final class ArticleModel extends BaseModel{
	protected $table = "article";

	//连表查询的多行数据
	public function fetchAllWithJoin($where,$startrow = 0,$pagesize = 10){
		//构建查询的数据库语句
		$sql = "SELECT article.*,category.classname,user.username  FROM {$this->table}";
		$sql .= " LEFT JOIN category ON article.category_id = category.id";
		$sql .= " LEFT JOIN user ON article.user_id=user.id";
		$sql .=" where {$where} ";
		$sql .= " ORDER BY article.orderby ASC,article.id DESC ";
		$sql .= "LIMIT {$startrow},{$pagesize} ";
		//执行sql语句，并返回二位数组
		return $this->pdo->fetchAll($sql);
	}
}