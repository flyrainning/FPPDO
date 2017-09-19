<?php

//基本连接方式

$DB_MySQL=array(
  array(
    'id'=>'1',
    'desc'=>'主数据库',
    'server' => 'localhost',
    'port' => 3306,
    'user' => 'root',
    'passwd' => 'root',
    'db' => '',
    'charset' => 'utf8',
    'prefix' => '',
    'options'=>array(),
  ),
);

$db=MySQL::open();

$data=array(
  array(
    'id'=>1,
    'name'=>"u1"
    ),
  array(
    'id'=>2,
    'name'=>"u2"
    ),
  array(
    'id'=>3,
    'name'=>"u2"
    ),
  );

$db->table("user");
$db->insert_array($data);

 ?>
