<?php
//包含基础模型类
require_once("./BaseModel.class.php");

//定义学生模型类，并继承基础模型类
class StudentModel extends BaseModel
{
	//获取多行数据
	public function fetchAll()
	{
		//构建查询的SQL语句
		$sql = "SELECT * FROM student ORDER BY id DESC";
		//执行SQL语句，返回二维数组
		return $this->db->fetchAll($sql);
	}

	//删除记录
	public function delete($id)
	{
		//构建删除的SQL语句
		$sql = "DELETE FROM student WHERE id={$id}";
		//执行SQL语句，并返回布尔值
		return $this->db->exec($sql);
	}
}