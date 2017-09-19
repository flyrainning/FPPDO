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

$db->table("log");

$log1=array(
  'user'=>"u1",
  'message'=>"something"
  );
$log2=array(
  'user'=>"u2",
  'message'=>"msg for u2"
  );

$db->insert($log1);
$db->insert($log2);

 ?>
