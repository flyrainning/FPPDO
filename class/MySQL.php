<?php
/*
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
 */
 require_once "FPPDO.php";

 class MySQL extends FPPDO {

   public static $dblist;



 	function __construct($id='') {

    global $DB_MySQL;
    $configarr=$DB_MySQL;
    is_array($configarr) or $this->error('config error');
    $c=array();
    if (empty($id)){
      $c=array_shift($configarr);
    }else{
      foreach ($configarr as $key => $value) {
        if ($value['id']==$id){
          $c=$value;
          break;
        }
      }
    }

    empty($c['server']) and $this->error('server error');

    $server=$c['server'];
    $user=$c['user'];
    $passwd=$c['passwd'];
    $db=$c['db'];
    $options=isset($c['options'])?$c['options']:array();
    $options=empty($options)?array():$options;
    $port=empty($c['port'])?3306:$c['port'];
    $charset=empty($c['charset'])?'utf8':$c['charset'];
    empty($c['prefix']) or $this->prefix($c['prefix']);


    $dsn="mysql:host=$server;dbname=$db;port=$port;charset=$charset";

    parent::__construct($dsn, $user, $passwd,$options);

 	}
  static function open($id=""){
    if (empty(self::$dblist)) self::$dblist=array();
    $key=empty($id)?"_default":$id;
    if (empty(self::$dblist[$key])) self::$dblist[$key]=new MYSQL($id);
    return self::$dblist[$key];
  }



 }

 ?>
