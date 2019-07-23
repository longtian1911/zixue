<?php
//累的自动加载，注册类的装载规则
spl_autoload_register(function($className){
	//构建所有不同规则类文件路径
	$arr = array(
		"./public/$className.class.php",
		"./libs/$className.class.php",
	);
	//循环数组
	foreach ($arr as $filename) {
		//如果累文件存在则包含
		if (file_exists($filename)) {
			require_once($filename);
		}
	}
});