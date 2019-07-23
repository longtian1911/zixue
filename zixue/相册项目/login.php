<?php
	//产生表单验证随机字符串   
	session_start();
	$_SESSION['token'] = uniqid();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>用户登录</title>
<style type="text/css">
/*全局样式*/
body,h2,form,a{margin:0px;padding:0px}
body{font-size:14px;color:#444;background-color:#00343f;}
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
form{padding:30px;height:400px;}
form td{padding:8px;}
</style>
</head>
<body>
<div class="box">
<!--title-->
<div class="title">
	<h2>用户登录</h2>
	<a href="javascript:void(0)">欢迎光临，请先登录！</a>
</div><!--//title-->
<!--form-->
<form method="post" action="loginSave.php">
<table align="center" width="400">
	<tr>
		<td width="100" align="right">用户名：</td>
		<td><input type="text" name="username"></td>
	</tr>
	<tr>
		<td align="right">密&nbsp;&nbsp;&nbsp;码：</td>
		<td><input type="password" name="password"></td>
	</tr>
	<tr>
		<td align="right">验证码：</td>
		<td>
			<input style="float:left;" type="text" name="verify" size="4" maxlength="4">
			<img style="float:left;margin-left:10px;cursor: pointer;height:22px;" src="./captcha.php" onclick="this.src='./captcha.php?'+Math.random()">
		</td>
	</tr>
	<tr>
		<td></td>
		<td>
			<input type="submit" value="登录">
			<input type="hidden" name="token" value="<?php echo $_SESSION['token']?>">
			<input type="reset" value="重置">
		</td>
	</tr>
</table>
</form><!--//form-->
</div><!--//box-->
</body>
</html>