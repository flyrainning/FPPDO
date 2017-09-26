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
    'driver'=>'dblib',
    'options'=>array(),
  ),
);

$db=MSSQL::open();

print_r($db);

$db->q("Select Name From Master..SysDatabases order By Name");

$result=$db->arr();
print_r($result);

 ?>
