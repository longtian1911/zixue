<?php
//开启session会话，产生新的sessionid或重用传递过来的sessionid
//产生sessionid 并创建对应的session
session_start();
echo "string";
$_SESSION['username'] = 'admin';

