<?php
//声明命名空间
namespace Frame\Vendor;
//包含元素的smarty类文件
require_once(ROOT_PATH.'Frame'.DS.'Vendor'.DS.'Smarty'.DS.'libs'.DS.'Smarty.class.php');
//定义自己的smarty类，并继承原始的smarty类
final class Smarty extends \Smarty{
	
}