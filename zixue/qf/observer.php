<?php
//观察者模式涉及到两个雷
//男人类和女朋友类
//男人类对象小明，小花，小丽

class Man{
	//用来存放观察者
	protect $observers = [];
	//添加观察者方法
	public function addObserver($observer){
		$this->observers[] = $observer;
	}

	//花钱方法
	public function buy(){
		//当被观察者做出这个行为的时候，让观察者得到通知，并且做出一定的反映
		foreach ($$this->observers as $girl) {
			$girl->dongjie();
		}
	}

	//删除观察者方法
	public function delObserver($observer){
		//查找对应值在数组 中的建
		$key = array_search($observer, $this->observers);
		//根据建删除数组的值，并且数组重新索引
		array_splice($this->observers, $key, 1);
	}
}

class GirlFriend{
	public function dongjie(){
		echo "男朋友正在花钱，麻烦冻结他的银行卡";
	}
}


//创建对象
$xiaoming = new Man();
$xiaohua = new GirlFriend();
$xiaoli = new GirlFriend();
//添加观察者
$xiaoming->addObserver($xiaohua);
$xiaoming->addObserver($xiaoli);

//删除观察者
$xiaoming->delObserver($xiaohua);

//买东西测试观察者有没有生效
$xiaoming->buy();

























