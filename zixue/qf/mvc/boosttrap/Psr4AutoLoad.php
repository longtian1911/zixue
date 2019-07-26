<?php 
class Psr4AutoLoad{
	//这里存放命名空间映射
	protected $maps = [];
	public function __construct(){
		spl_autoload_register([$this, 'autoload']);
	}

	//自己写的自动加载函数
	public function autoload($className){
		//完整的类名由命名空间名和类名组成
		//得到命名空间名，根据命名空间名得到期目录路径
		$pos = strrpos($className, '\\'); //strrpos查找  在字符串中最后一次出现的位置：
		$namespace = substr($className, 0, $pos);
		//得到类名
		$realClass = substr($className, $pos + 1);
		//找到文件并且包含进来
		$this->mapLoad($namespace,$realClass);
	}

	//根据命名空间名得到目录路径，并且拼接真正的文件全路径
	protected function mapLoad($namespace,$realClass){
		if (array_key_exists($namespace, $this->maps)) {
			$namespace = $this->maps[$namespace];
		}
		//处理路径
		$namespace = rtrim(str_replace('\\', DIRECTORY_SEPARATOR, $namespace), '/') . '/';
		//拼接文件全路径
		$filePath = $namespace . $realClass . '.php';
		//将该文件包含进来
		if (file_exists($filePath)) {
			include_once $filePath;
		}else{
			die('该文件不存在');
		}	
	}

	//给一个命名空间，给一个路径，将命名空间的路径保存到映射数组中
	public function addMaps($namespace, $path){
		if (array_key_exists($namespace, $this->maps)) {
			die('此命名空间已经映射过');
		}
		//将命名空间的路径已键值对的形式存放到数组中
		$this->maps[$namespace] = $path;
	}
}