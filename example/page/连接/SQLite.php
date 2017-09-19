<?php

//使用MySQL类

$DB_SQLite=array(
  array(
    'id'=>'1',
    'desc'=>'主数据库',
    'file' => '',
    'prefix' => '',
    'options'=>array(),
  ),
);

$db=SQLite::open();

print_r($db);

$db->q("show databases");

$result=$db->arr();
print_r($result);

 ?>
