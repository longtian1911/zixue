<?php
//包含连接数据库的公共文件
require_once('./conn.php');
//开启session会话
session_start();
//判断表单是否合法体检
if (isset($_POST['token']) && $_POST['token'] == $_SESSION['token']) {
	//获取表单提交数据
	$username = $_POST['username']; //用户名
	$password = md5($_POST['password']); //加密字符密码
	$verify = strtolower($_POST['verify']); //验证码

	//判断验证码与服务器保存的是否一致
	if ($verify != $_SESSION['captcha']) {
		echo "<h2>验证码输入错误</h2>";
		header("refresh:3;url=./login.php");
		die();
	}
	//判断用户名和密码与数据库是否一致
	$sql = "SELECT * FROM user WHERE username='$username' AND password='$password'";
	$result = mysqli_query($link,$sql);//执行sql语句
	$records = mysqli_num_rows($result); //取回记录数 ，如果有1条则 说明存在，没有则没找到
	if (!$records) {
		echo "<h2>用户名或密码不正确！</h2>";
		header("refresh:3;url=./login.php");
		die();
	}
	//保存用户信息到session中
	$_SESSION['username'] = $username;
	//跳转到相册首页
	header("location:./index.php");
}else{
	//直接跳转到login.php
	header("location:./login.php");
}