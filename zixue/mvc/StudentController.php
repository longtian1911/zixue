<?php
//包含学生模型类
require_once("./StudentModel.class.php");

//获取用户动作参数
$ac = isset($_GET['ac']) ? $_GET['ac'] : '';
//根据用户的不同动作，调用不同的方法
if($ac=='delete')
{
	//获取地址栏传递的id
	$id = $_GET['id'];
	//创建学生模类对象
	$modelObj = new StudentModel();
	//判断是否删除成功
	if($modelObj->delete($id))
	{
		echo "<h2>id={$id}的记录删除成功！</h2>";
		header("refresh:3;url=?");
		die();
	}else
	{
		echo "<h2>id={$id}的记录删除失败！</h2>";
		header("refresh:3;url=?");
		die();		
	}
}else
{
	//创建学生模型类对象
	$modelObj = new StudentModel();
	//获取多行数据
	$arrs = $modelObj->fetchAll();
	//包含学生首页视图文件
	include "./StudentIndexView.html";
}