<?php
//数据库配置信息
$dns = "mysql:host=127.0.0.1;port=3306;dbname=php68;charset=utf8";
$username = 'root';
$password = 'liuliliuli';
//创建pdo对象
$pdo = new PDO($dns,$username,$password);
$sql = "INSERT INTO user VALUES(null,'admin','123')";
$result = $pdo->exec($sql);
echo $result;
var_dump($result);