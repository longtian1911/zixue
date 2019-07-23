<?php
//判断表单的来源是否合法
if(isset($_POST['token']) && $_POST['token']=='upload')
{
	print_r($_FILES);
	//创建finfo的资源：获取文件内容类型，与扩展名无关
	$finfo = finfo_open(FILEINFO_MIME_TYPE);
	//获取文件内容的原始类型，不会随着扩展名改名而改变
	$content_type = finfo_file($finfo,$_FILES['uploadFile']['tmp_name']);
	echo "文件内容类型：".$content_type;
	die();
}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>上传文件的内容类型的判断</title>
</head>
<body>
<form name="form1" method="post" action="" enctype="multipart/form-data">
上传图片：<input type="file" name="uploadFile">
<input type="submit" value="上传">
<input type="hidden" name="token" value="upload">
</form>
</body>
</html>