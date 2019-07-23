<?php
//定义矩形类,并实现形状接口
class Rectangle implements Shape{
	//重写draw方法
	public function draw(){
		echo "正在绘制矩形";
	}
}