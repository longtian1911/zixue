<?php

namespace app\index\controller;


use think\Controller;

class Demo extends Controller {
    //前置操作方法列表
    protected $beforeActionList = [

    ];

    public function index(){
        return '这是首页';
    }

    private function aa(){
        return '<hr /> aaa';
    }
}