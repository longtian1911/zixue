<?php
namespace Home\Model;
use Frame\Libs\BaseModel;
final class ArticleModel extends BaseModel{
	protected $table = 'article';

	//获取文章按月份归档数据
	public function fetchAllWithCount(){
		//构建查询的sql语句
		$sql = "SELECT date_format(from_unixtime(addate),'%Y年%m月') as yearmonth, ";
		$sql .= "count(id) as article_count FROM {$this->table} ";
		$sql .= "GROUP BY yearmonth ";
		$sql .= "ORDER BY yearmonth DESC";
		//返回查询的
		return $this->pdo->fetchAll($sql);
	}

	//获取文章连表查询数据
	public function fetchAllWithJoin($where,$startrow,$pagesize){
		//构建连表查询的sql语句
		$sql = "SELECT article.*,user.name,category.classname FROM {$this->table} ";
		$sql .= "LEFT JOIN user ON article.user_id=user.id ";
		$sql .= "LEFT JOIN category ON article.category_id = category.id ";
		$sql .= " where  $where ";
		$sql .= "ORDER BY article.id DESC ";
		$sql .="LIMIT {$startrow},{$pagesize}";
		//执行sql语句
		return $this->pdo->fetchAll($sql);
	}
}