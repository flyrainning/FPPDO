<?php

//使用MSSQL类

$DB_MSSQL=array(
  array(
    'id'=>'1',
    'desc'=>'主数据库',
    'server' => 'localhost',
    'port' => 1433,
    'user' => 'root',
    'passwd' => 'root',
    'db' => '',
    'charset' => 'utf8',
    'prefix' => '',
    'options'=>array(),
  ),
);

$db=MSSQL::open();

print_r($db);

$db->q("show databases");

$result=$db->arr();
print_r($result);

 ?>
