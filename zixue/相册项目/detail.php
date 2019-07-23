<?php
//包含连接数据库的公共文件
require_once("./conn.php");

//开启SESSION会话
session_start();
//判断用户是否登录
if(empty($_SESSION['username']))
{
	//如果用户没有登录，则直接跳转到login.php
	header("location:./login.php"); 
	die();
}

//获取地址栏传递的id
$id = $_GET['id'];
//更新访问量
$sql = "UPDATE photos SET hits=hits+1 WHERE id=$id";
mysqli_query($link,$sql);

//构建查询的SQL语句
$sql = "SELECT * FROM photos WHERE id=$id";
//执行SQL语句，返回结果集对象
$result = mysqli_query($link, $sql);
//获取一行数据
$arr = mysqli_fetch_assoc($result);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>照片详细信息</title>
<style type="text/css">
/*全局样式*/
body,ul,li,h2,a{margin:0px;padding:0px}
body{font-size:14px;color:#444;background-color:#00343f;}
ul,li{list-style: none;}
a{text-decoration:none;color:#444;}
a:hover{color:red;} 
/*局部样式*/
.box{width:1000px;margin:0px auto;background-color:white;}
.title{
	text-align:center;
	padding: 10px 0px;
	border-bottom: 2px solid #444;
	background-color:#d0e9ff;
}
.title h2{font-size:36px;padding:10px;}
.detail{padding:15px 100px;}
.detail div{text-align:center;}
.detail img{width:640px;}
.detail p{font-size:16px;text-indent: 36px; font-family: 微软雅黑;line-height: 28px;}
</style>
</head>
<body>
<div class="box">
<!--title-->
<div class="title">
	<h2><?php echo $arr['title']?></h2>
	访问<font color=red><?php echo $arr['hits']?></font>次，
	发布时间 <font color=red><?php echo date("Y-m-d H:i:s",$arr['addate'])?></font>，
	<a href="./index.php">返回首页</a>
</div><!--//title-->
<!--photos-->
<div class="detail">
	<div class="photo"><img align="center" src="<?php echo $arr['imgsrc']?>"></div>
	<p><?php echo $arr['intro']?></p>
</div><!--//photos-->
</div><!--//box-->
</body>
</html>