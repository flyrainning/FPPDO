<?php

print_r(error_reporting());

function myErrorHandler($errno, $errstr, $errfile, $errline)
{


    switch ($errno) {
    case E_USER_ERROR:
        echo "<b>My ERROR</b> [$errno] $errstr<br />\n";
        echo "  Fatal error on line $errline in file $errfile";
        echo ", PHP " . PHP_VERSION . " (" . PHP_OS . ")<br />\n";
        echo "Aborting...<br />\n";
        exit(1);
        break;

    case E_USER_WARNING:
        echo "<b>My WARNING</b> [$errno] $errstr<br />\n";
        break;

    case E_USER_NOTICE:
        echo "<b>My NOTICE</b> [$errno] $errstr<br />\n";
        break;

    default:
        echo "Unknown error type: [$errno] $errstr<br />\n";
        break;
    }

    /* Don't execute PHP internal error handler */
    return true;
}

set_error_handler("myErrorHandler");

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
