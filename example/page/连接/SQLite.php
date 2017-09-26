<?php



//使用SQLite类

$DB_SQLite=array(
  array(
    'id'=>'1',
    'desc'=>'主数据库',
    'file' => '',//file为空，使用内存数据库
    'prefix' => '',
    'options'=>array(),
  ),
);


$init_sql=<<<CODE
CREATE TABLE `newtable` (
	`Field1`	INTEGER,
	`Field2`	TEXT,
	`Field3`	BLOB,
	`Field4`	REAL,
	`Field5`	NUMERIC
);
CODE;
$db=SQLite::open('',$init_sql);

print_r($db);

$db->table('newtable');

$db->insert(array(
  'Field1'=>1,
  'Field2'=>"data",
));

$db->select();

$result=$db->arr();
print_r($result);

 ?>
