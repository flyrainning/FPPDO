<?php
/*

$DB_SQLite=array(
   array(
     'id'=>'1',
     'desc'=>'主数据库',
     'file' => '',
     'prefix' => '',
     'options'=>array(),
   ),
 );

 */
require_once "FPPDO.php";

class SQLite extends FPPDO{
  function __construct($id="",$init_sql="") {

   global $DB_SQLite;
   $configarr=$DB_SQLite;
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

   $file=empty($c['file'])?':memory:':$c['file'];

   $options=isset($c['options'])?$c['options']:array();
   $options=empty($options)?array():$options;

   empty($c['prefix']) or $this->prefix($c['prefix']);

   $dsn="sqlite:$file";

   parent::__construct($dsn, NULL, NULL,$options);

   empty($init_sql) or $this->q($init_sql);

 }
 static function open($id="",$init_sql=""){
   global $G_SQLite_Object;
   if (empty($G_SQLite_Object)) $G_SQLite_Object=new SQLite($id,$init_sql);
   return $G_SQLite_Object;
 }



}

?>
