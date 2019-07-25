<?php
//单列对象
/**
 * 
 */
class Dog
{
	//静态属性保存单列对象
	static private $instance;

	//通过静态方法来创建单列对象
	private function __construct(argument)
	{
		//判断$instance是否为空，如果为空，则new一个对象，如果不为空则直接返回
		if (!self::$instance) {
			self::$instance = new self();
		}
		return self::$instance;
	}
}