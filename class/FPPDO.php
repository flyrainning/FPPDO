<?php
/**
 * FPPDO class
 */

 class FPPDO extends PDO {

 	public $result;
  private $debug,$is_showerror;
  public $table;
  public $prefix;
  public $is_error;


 	function __construct($dsn, $user, $passwd,$options) {
    $this->debug=false;
    $this->is_showerror=true;
    $this->prefix="";
    try {
        parent::__construct($dsn, $user, $passwd,$options);
    } catch (PDOException $e) {
        $this->error('Connection failed: ' . $e->getMessage());
    }
    $this->setAttribute( PDO::ATTR_EMULATE_PREPARES, false );

 	}
  public function showerror($dbg=true){
    if ($dbg){
      $this->is_showerror=true;
    }else{
      $this->is_showerror=false;
    }
  }
  public function debug($dbg=true){
    if ($dbg){
      $this->debug=true;
    }else{
      $this->debug=false;
    }
    $this->showerror($dbg);
  }
  function debug_show($msg){
    if ($this->debug){
      echo "\n\n --- DB Debug : \n";
      print_r($msg);
      echo "\n ---\n\n";
    }
  }
  function pre_sql($sqls){
    return $sqls;
  }
  function q($sql){
    $this->is_error=false;
    $pa=func_get_args();
    $this->result=false;
    if (!empty($this->table)){
      $sql=str_replace('{table}',$this->table,$sql);
      $sql=str_replace('{prefix}',$this->prefix,$sql);
    }
    $sql=$this->pre_sql($sql);
		if (!empty($pa[1])){//如果有变量，进行绑定
      array_shift($pa);
      if (is_array($pa[0])) $pa=$pa[0];
      $this->debug_show($sql);
      $this->debug_show($pa);

      try {
          $stmt = $this->prepare($sql);
          $this->beginTransaction();
          if (isset($pa[0]) && (is_array($pa[0]))){
            foreach ($pa as $pavalue) {
              $stmt->execute($pavalue);
            }

          }else{
            $stmt->execute($pa);
          }

          $this->commit();
          $this->result=$stmt;
      } catch(PDOExecption $e) {
          $this->is_error=true;
          $this->rollback();
          $this->error($e->getMessage() . "</br>");
      }
    }else{//如果单条语句，直接执行


      $this->debug_show($sql);
      $this->result=$this->query($sql);
    }

    return $this->result;
  }
  function v($string){
    return $this->quote($string);
  }
  function v_arr($arr){
    if (is_array($arr)){
      foreach ($arr as $k=>$v){
  			$arr[$k]=$this->quote($v);
  		}
    }

		return $arr;

	}
  function prefix($prefix=''){
    $this->prefix=$prefix;
  }
  function gettable($table){
    return $this->prefix.$table;
  }
  function table($table,$change_table=true){
    $pretable=$this->gettable($table);
    if ($change_table){
      $this->table=$pretable;
    }
		return $pretable;
	}
  function error($msg){
    if ($this->is_showerror){
      echo 'DB Error : '.$msg;
      die();
    }
  }
  function one($result=''){
    $res=array();
    if (empty($result)){
			$result=$this->result;
		}
    if (is_object($result)) $res=$result->fetch(PDO::FETCH_ASSOC);
    return $res;
  }
  function arr($result=''){
    $res=array();
    if (empty($result)){
			$result=$this->result;
		}
    if (is_object($result)) $res=$result->fetchAll(PDO::FETCH_ASSOC);
    return $res;
  }
  function count($result=''){
    $res=-1;
    if (empty($result)){
      $result=$this->result;
    }
		if (is_object($result)) $res=$result->rowCount();
		return $res;
	}
  function has($where){
    $sql="select count(*) FROM `".$this->table."` WHERE ".$where;

    $pa=func_get_args();
    if (isset($pa[1])){//如果有变量，进行绑定
      array_shift($pa);
      if (is_array($pa[0])) $pa=$pa[0];
    }else{
      $pa=array();
    }

    $sqls="SELECT count(*) as `c` FROM `".$this->table."` ";
    if (!empty($where)) $sqls.="WHERE ".$where;

    $res=$this->q($sqls,$pa);
    $item=$this->one($res);

     return isset($item['c'])?$item['c']:0;

  }
  function make_global($result='',$header='',$replace=true){//header : 变量前缀
		$res=false;
		if (is_array($result)){
			$arr=$result;
		}else{
			if (empty($result)){

				$result=$this->result;
			}


			$arr=$this->one($result);
		}

		foreach($arr as $k=>$v){
			$keyname=$header.$k;
			global ${$keyname};

			if ((isset(${$keyname})) &&(!$replace)) $this->error('sql var repeated : '.$keyname);
			${$keyname}=$v;
			$res=true;
		}
		return $res;

	}
  function lastid(){
		return $this->lastInsertId();
	}
  function result_reset(){
    $this->result=false;
    return $this->result;
  }

  function insert($arr){
    $res=false;
    if (is_array($arr)&&(!empty($arr))){
      if (empty($this->table)) $this->error('sql table error');
      $ks='';
  		$vs='';
      foreach($arr as $k=>$v){
        $ks.="`$k`,";
        $vs.=":$k,";
      }
      $ks=trim($ks,',');
  		$vs=trim($vs,',');
      $sqls="INSERT INTO `".$this->table."` ($ks) VALUES ($vs);";
      $res=$this->q($sqls,$arr);
    }else{
      $res=$this->result_reset();
      $this->error('Data Not Array or Data is Empty');
    }

		return $res;

	}
  function select($col='*',$where=''){

    if (empty($col)) $col='*';

    $pa=func_get_args();
    if (isset($pa[2])){//如果有变量，进行绑定
      array_shift($pa);
      array_shift($pa);
      if (is_array($pa[0])) $pa=$pa[0];
    }else{
      $pa=array();
    }

    $sqls="SELECT $col FROM `".$this->table."` ";
    if (!empty($where)) $sqls.="WHERE ".$where;

    return $this->q($sqls,$pa);
  }
  function delete($where){
    if (empty($where)) $this->error('where not found');
    $pa=func_get_args();
    if (isset($pa[1])){//如果有变量，进行绑定
      array_shift($pa);
      if (is_array($pa[0])) $pa=$pa[0];
    }else{
      $pa=array();
    }
    $sqls="DELETE FROM `".$this->table."` WHERE ".$where;

    return $this->q($sqls,$pa);
  }

  function update($arr,$where=''){


    $res=false;
    if (is_array($arr)&&(!empty($arr))){
      if (empty($this->table)) $this->error('sql table error');
      $ks='';
      foreach($arr as $k=>$v){
        $ks.="`$k`=:$k,";
      }
      $ks=trim($ks,',');

      if (empty($where)){
        $res=$this->result_reset();
        $this->error('Where is Empty');
        return $res;
      }

      if (is_array($where)){
        $neww='';
        foreach($where as $k=>$v){
          if (empty($neww)){
            $neww.="(`$k`=:where_p_$k )";
          }else{
            $neww.=" and (`$k`=:where_p_$k )";
          }
          $arr["where_p_$k"]=$v;
        }
        $where=$neww;
      }else{
        if (strpos($where,'`')===flase) $this->error('Where Format Error');
      }

      $sqls="UPDATE `".$this->table."` SET $ks WHERE $where;";
      $res=$this->q($sqls,$arr);
    }else{
      $res=$this->result_reset();
      $this->error('Data Not Array or Data is Empty');
    }

    return $res;
  }

  function replace($arr){
    $res=false;
    if (is_array($arr)&&(!empty($arr))){
      if (empty($this->table)) $this->error('sql table error');
      $ks='';
  		$vs='';
      $update='';
      foreach($arr as $k=>$v){
        $ks.="`$k`,";
        $vs.=":$k,";
        $update.="`$k`=:$k,";
      }
      $ks=trim($ks,',');
  		$vs=trim($vs,',');
      $update=trim($update,',');
      $sqls="INSERT INTO `".$this->table."` ($ks) VALUES ($vs) ON DUPLICATE KEY UPDATE $update;";
      $res=$this->q($sqls,$arr);
    }else{
      $res=$this->result_reset();
      $this->error('Data Not Array or Data is Empty');
    }
		return $res;
  }

  function insert_array($arr){

		return $this->set_array($arr,'insert');
	}
	function replace_array($arr){
		return $this->set_array($arr,'replace');
	}
	function set_array($iarr,$type="replace"){
    $this->result_reset();
    if (empty($this->table)) $this->error('sql table error');
    if (is_array($iarr) && is_array($iarr[0]) &&(!empty($iarr[0]))){
      $ks='';
  		$vs='';
      $update='';
      foreach($iarr[0] as $k=>$v){
        $ks.="`$k`,";
        $vs.=":$k,";
        $update.="`$k`=:$k,";
      }
      $ks=trim($ks,',');
  		$vs=trim($vs,',');
      $update=trim($update,',');
      $type=strtolower($type);
      $sqls="";
      if ($type=="insert"){
        $sqls="INSERT INTO `".$this->table."` ($ks) VALUES ($vs);";

      }else if ($type=="replace"){
        $sqls="INSERT INTO `".$this->table."` ($ks) VALUES ($vs) ON DUPLICATE KEY UPDATE $update;";

      }else{
        $this->error("Set Array Type Error</br>");
      }
      try {
          $stmt = $this->prepare($sqls);
          $this->beginTransaction();
          foreach ($iarr as $value) {
            $stmt->execute($value);
          }
          $this->commit();
          $this->result=$stmt;
      } catch(PDOExecption $e) {
          $this->rollback();
          $this->error($e->getMessage() . "</br>");
      }

    }

    return $this->result;

  }



 }

 ?>
