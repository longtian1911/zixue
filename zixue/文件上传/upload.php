<?php
//判断标段是否合法提交
if (isset($_POST['token']) && $_POST['token'] == 'upload') {
	//将上传的的临时文件，移动到./upload目录
	// $tmp_name = $_FILES['uploadFile']['tmp_name'];
	// $dst_name = './upload/img01.jpg';
	// move_uploaded_file($tmp_name, $dst_name);
	//判断上传文件有没有错误
	if ($_FILES['uploadFile']['error'] != 0 ) {
		echo "<h2>上传文件发生了错误！</h2>";
		die();
	}
	//判断上传文件是否超过2M
	if ($_FILES['uploadFile']['size'] > 2*1024*1024) {
		echo "<h2>上传文件大小超过2M</h2>";
		die();
	}

	//判断文件是否为图片
	$arr = array('image/jpeg','image/png','image/gif');
	$type = $_FILES['uploadFile']['type'];
	if (!in_array($type, $arr)) {
		echo "<h2>您上传的不是图片</h2>";
		die();
	}
	//将上传的的临时文件，移动到./upload目录
	$ext = pathinfo($_FILES['uploadFile']['name'],PATHINFO_EXTENSION); //获取文件路径信息，可以获取很多值可以查手册
	$filename = substr($_FILES['uploadFile']['name'], 0,-(strlen($ext)+1));//获取上传文件名
	$tmp_name = $_FILES['uploadFile']['tmp_name'];
	$dst_name = './upload/'.uniqid($filename.'_',true).'.'.$ext;//uniqid生成唯一字符串里面有两个参数可以省略：参数一：设置生成字符串前缀 参数二：设置字符串长度默认为13位设置为24位
	move_uploaded_file($tmp_name, $dst_name);
}else{
	echo "非法提交";
}
finfo_open();