<?php
namespace app\index\controller;

use think\Controller;

class Index extends Controller
{
    public function index()
    {
        return view('index@index/index');
    }

    public function demo() {
        dump($_SERVER);
    }

}
