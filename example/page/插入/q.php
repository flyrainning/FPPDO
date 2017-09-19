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


$sqls=<<<SQL
update `{perfix}.user` set
 `username`=:username,
 `email`=:email
 where
 `uid`=:uid
SQL;

$db->q($sqls,array(
  'uid'=>1,
  'username'=>'u1',
  'email'=>'email@email.com'
  ));

 ?>
