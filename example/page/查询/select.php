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

$db->table("user");

$db->select('uid,username,email','`uid`=?',$uid);

$user_info=$db->one();
print_r($user_info);

?>
