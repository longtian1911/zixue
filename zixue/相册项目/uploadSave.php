<?php
//包含连接数据库的公共文件
require_once("./conn.php");
//开启session会话
session_start();
//判断用户是否登录
if (empty($_SESSION['username'])) {
	//如果用户没有登录，则直接跳转到登录页面
	header('location:./login.php');
	die();
}
//判断表单的来源是否合法
if (isset($_POST['token']) && $_POST['token'] == $_SESSION['token']) {
	//************上传图片************
	//判断上传图片是否有错误发生
	if ($_FILES['uploadFile']['error'] != 0) {
		echo "<h2>上传图片有错误发生！</h2>";
		header('refresh:3;url=./upload.php');
		die();
	}
	//判断上传的文件类型是不是图片
	$arr1 = array('image/jpeg','image/png','image/gif');
	//创建finfo的资源，获取文件内容类型，与扩展名无关
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	//获取文件内容的原始类型，不会随着扩展名改名而改变
	$mime = finfo_file($finfo, $_FILES['uploadFile']['tmp_name']);
	if (!in_array($mime,$arr1)) {
		echo "<h2>上传的必须是图片！</h2>";
		header('refresh:3;url=./upload.php');
		die();
	}
	//判断上传的文件扩展名是不是图片
	$arr1 = array('jpg','gif','png');
	//获取文件的类型
	$ext = pathinfo($_FILES['uploadFile']['name'],PATHINFO_EXTENSION);
	if (!in_array($ext, $arr1)) {
		echo "<h2>上传的必须是图片！</h2>";
		header('refresh:3;url=./upload.php');
		die();
	}
	//移动图片到images目录中
	//获取文件路径信息，可以获取很多值可以查手册
	$filename = substr($_FILES['uploadFile']['name'], 0,-(strlen($ext)+1));//获取上传文件名
	$tmp_name = $_FILES['uploadFile']['tmp_name'];
	$dst_name = './images/'.uniqid($filename.'_',true).'.'.$ext;//uniqid生成唯一字符串里面有两个参数可以省略：参数一：设置生成字符串前缀 参数二：设置字符串长度默认为13位设置为24位
	move_uploaded_file($tmp_name, $dst_name);
	//********将表单数据提交到数据***************
	//获取表单数据
	//获取表单提交数据
	$title = $_POST['title'];
	$intro = $_POST['intro'];
	$addate = time();// 发布时间
	$imgsrc = $dst_name; //将图片路径保存到数据库
	//判断记录是否添加成功
	$sql = "INSERT INTO photos (title,imgsrc,intro,addate) VALUES ('$title','$imgsrc','$intro','$addate')";
	if (mysqli_query($link,$sql)) {
		echo "<h2>上传照片成功！</h2>";
		header("refresh:3;url=./index.php");
		die();
	}

	
}else{
	//直接跳转到index.php页面
	header('location:./index.php');
}
