<?php
//声明命名空间
namespace Frame\Libs;
use Frame\Vendor\PDOWrapper;
//定义抽象的基础模型类
abstract class BaseModel{
	//受保护的pdo对象属性
	protected $pdo = null;
	//构造方法
	public function __construct(){
		//创建pdowrapper类的对象
		$this->pdo = new PDOWrapper();
	}

	//创建不同模型类对象的方法
	public static function getInstance(){
		//获取静态化方式调用的类名
		$modelClassName = get_called_class();
		//创建自定模型类对象,并返回
		return new $modelClassName();
	}

	//获取一行数据
	public function fetchOne($where="2>1")
	{
		//构建查询的SQL语句
		$sql = "SELECT * FROM {$this->table} WHERE {$where}";
		//执行SQL语句，返回一维数组
		return $this->pdo->fetchOne($sql);
	}
	//获取多行数据
	public function fetchAll($orderby="id DESC")
	{
		//构建查询的SQL语句
		$sql = "SELECT * FROM {$this->table} ORDER BY ".$orderby;
		//执行SQL语句，返回二维数组
		return $this->pdo->fetchAll($sql);
	}

	//删除记录
	public function delete($id)
	{
		//构建删除的SQL语句
		$sql = "DELETE FROM {$this->table} WHERE id={$id}";
		//执行SQL语句，并返回布尔值
		return $this->pdo->exec($sql);
	}

	//添加记录
	public function insert($data)
	{
		//构建"字段列表"和"值列表"字符串
		$fields = '';
		$values = '';
		foreach($data as $key=>$value)
		{
			$fields .= "$key,";
			$values .= "'$value',";
		}
		//去除结尾的逗号
		$fields = rtrim($fields,',');
		$values = rtrim($values,',');
		//构建插入的SQL语句：INSERT INTO news(title,content,hits) VALUES('标题','内容','30')
		$sql = "INSERT INTO {$this->table}($fields) VALUES($values)";
		//执行SQL语句，并返回布尔值
		return $this->pdo->exec($sql);
	}
	//更新记录
	public function update($data,$id)
	{
		//构建“字段名=字段值”的字符串
		$str = "";
		foreach ($data as $key => $value) 
		{
			$str .="{$key}='{$value}',";
		}
		//去除结尾的逗号
		$str = rtrim($str,',');
		//构建更新的SQL语句
		$sql = "UPDATE {$this->table} SET {$str} WHERE id={$id}";
		//执行SQL语句并返回布尔值
		return $this->pdo->exec($sql);
	}
	//获取记录数
	public function rowCount($where="2>1")
	{
		//构建查询的SQL语句
		$sql = "SELECT * FROM {$this->table} WHERE {$where}";
		//执行SQL语句，并返回记录数
		return $this->pdo->rowCount($sql);
	}
}