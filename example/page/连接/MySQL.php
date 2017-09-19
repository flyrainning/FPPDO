<?php

//基本连接方式

$DB_MySQL=array(
  array(
    'id'=>'1',
    'desc'=>'主数据库',
    'server' => '',
    'port' => 3306,
    'user' => 'root',
    'passwd' => '',
    'db' => '',
    'charset' => 'utf8',
    'prefix' => '',
    'options'=>array(),
  ),
);

$db=MySQL::open();

print_r($db);

$db->q("show databases");

$result=$db->arr();
print_r($result);

 ?>
