<?php
//类的自动加载
spl_autoload_register(function($className){
	//构建类文件的路径
	$filename = "./libs/$className.class.php";
	if (file_exists($filename)) {
		require_once($filename);
	}
});
//创建矩形对象
$rectangle = Factory::getInstance('Rectangle');
$rectangle->draw();