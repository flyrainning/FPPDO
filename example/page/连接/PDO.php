<?php

//基本连接方式

$server="172.0.8.5";
$user="root";
$passwd="xxzx";
$port=3306;
$charset='utf8';
$db="mydb";
$options=array();

$dsn="mysql:host=$server;dbname=$db;port=$port;charset=$charset";

$db=new FPPDO($dsn, $user, $passwd,$options);

print_r($db);

$db->q("show databases");

$result=$db->arr();
print_r($result);

 ?>
