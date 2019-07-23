<?php
//定义一个基础商品类
//基础类是为了继承，不能直接创建对象
class Shop{
	//私有的商品的属性
	private $name;//商品名称
	private $price;//商品价格

	//受保护的构造方法
	protected function __construct($name,$price){
		$this->name = $name;
		$this->price = $price;
	}

	//受保护的显示商品方法
	protected function showInfo(){
		$str = "商品名称：{$this->name}";
		$str .= "<br />商品价格：{$this->price}";
		return $str;
	}
}

//创建手机类，并继承商品类
class Mobile extends Shop{
	//私有的手机属性
	public $pinpai;//手机品牌
	private $city;//手机产地

	//公开的手机构造方法
	public function __construct($name,$price,$pinpai,$city){
		//调用父类的构造方法
		parent::__construct($name,$price);
		$this->pinpai = $pinpai;
		$this->city = $city;
	}

	//重写显示商品信息
	public function showInfo(){
		$str = parent::showInfo();
		$str .= "<br />手机品牌：{$this->pinpai}";
		$str .= "<br />手机产地：{$this->city}";
		return $str;
	}
	public function t(){
		return $this;
	}
}
$a =new Mobile('黎明',12,'美的','长沙');
echo $a->t()->pinpai;