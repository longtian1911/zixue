<?php
//包含新闻模型类
//包含工程模型类
require_once('./FactoryModel.class.php');

//获取用户动作参数
$ac = isset($_GET['ac']) ? $_GET['ac'] : '';
//根据用户的不同动作，调用不同的方法
if($ac=='delete')
{
	//获取地址栏传递的id
	$id = $_GET['id'];
	//创建新闻模类对象
	$modelObj = FactoryModel::getInstance('NewsModel');
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
	//创建新闻模型类对象
	$modelObj = new NewsModel();
	//获取多行数据
	$arrs = $modelObj->fetchAll();
	//包含新闻首页视图文件
	include "./NewsIndexView.html";
}