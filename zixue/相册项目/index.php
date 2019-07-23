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

//每页显示多少条
$pagesize = 15;
//获取当前页码，并计算开始行号
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$startrow = ($page-1)*$pagesize;
//获取总记录数和计算总页数
$sql = "SELECT * FROM photos";
$result = mysqli_query($link, $sql);
$records = mysqli_num_rows($result);
$pages = ceil($records/$pagesize);

//构建查询的分页的SQL语句
$sql = "SELECT * FROM photos ORDER BY id DESC LIMIT {$startrow},{$pagesize}";
$result = mysqli_query($link, $sql);
$arrs = mysqli_fetch_all($result,MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>相册首页</title>
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
.photos{padding:15px;}
.photos li{
	float:left;
	width:290px;
	padding:8px 5px;
	margin:10px;
	text-align:center;
	border:1px solid red;
}
.photos img{width:280px;height:160px;}
.pagelist{height:40px;line-height:40px;text-align:center;}
.pagelist a{padding:8px 15px;margin:0px 3px;border:1px solid #ccc;}
.pagelist a:hover{border:1px solid #0000ff;}
.pagelist .current{padding:8px 15px;}
</style>
</head>
<body>
<div class="box">
<!--title-->
<div class="title">
	<h2>我的相册</h2>
	<a href="./upload.php">上传照片</a>
	共有个<font color='red'><?php echo $records?></font>照片
</div><!--//title-->
<!--photos-->
<div class="photos">
	<ul>
		<?php
		//循环二维数组
		foreach($arrs as $arr){
		?>
		<li>
			<a href="./detail.php?id=<?php echo $arr['id']?>"><img src="<?php echo $arr['imgsrc']?>"></a>
			<a href="./detail.php?id=<?php echo $arr['id']?>"><?php echo $arr['title']?></a>
		</li>
		<?php }?>
	</ul>
	<div style="clear:both"></div>
	<div class="pagelist">
		<?php
		//循环起点和终点
		$start = $page-5;
		$end   = $page+4;
		//如果当前页<=6时
		if($page<=6)
		{
			$start = 1;
			$end   = 10;
		}
		//如果$page>=$pages-4
		if($page>=$pages-4)
		{
			$start = $pages-9;
			$end   = $pages;
		}
		//如果$pages<10
		if($pages<10)
		{
			$start = 1;
			$end   = $pages;
		}
		//循环输出所有页码
		for($i=$start;$i<=$end;$i++)
		{
			//当前页不加链接
			if($page==$i)
			{
				echo "<span class='current'>$i</span>";
			}else
			{
				echo "<a href='./index.php?page=$i'>$i</a>";
			}
		}
		?>
	</div>
</div><!--//photos-->
</div><!--//box-->
</body>
</html>