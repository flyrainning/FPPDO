<?php
/**
 * MySQL class
 */
 require_once "FPPDO.php";

 class MySQL extends FPPDO {


 	function __construct($id='') {

    global $DB_MySQL;
    $configarr=$DB_MySQL;
    is_array($configarr) or $this->error('config error');
    $c=array();
    if (empty($id) || (!isset($configarr[$id]))){
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
    global $G_MySQL_Object;
    if (empty($G_MySQL_Object)) $G_MySQL_Object=new MySQL($id);
    return $G_MySQL_Object;
  }
  function error($msg){
      echo 'DB Error : '.$msg;
      die();
  }


 }

 ?>
