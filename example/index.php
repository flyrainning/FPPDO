<?php

require "../class/FPPDO.php";
require "../class/MSSQL.php";
require "../class/MySQL.php";
require "../class/SQLite.php";


$act=$_REQUEST['act'];
$code=$_REQUEST['code'];
$page=$_REQUEST['page'];

if (empty($act)){

  if (file_exists($page)) {
  	$code=file_get_contents($page);
    $code=str_replace("<?php","",$code);
    $code=str_replace("<?","",$code);
    $code=str_replace("?>","",$code);
  }else{
    $code="";
  }

}


 ?>

<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FPPDO Example</title>

    <!-- jquery -->
    <script src="lib/jquery/jquery-1.11.3.min.js"></script>

    <!-- Bootstrap -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>


  </head>
  <body>
    <div class="container">

      <div class="page-header">
        <h1>Example <small>for FPPDO</small></h1>
      </div>

      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
            <a class="navbar-brand" href="#">Example</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" >
            <ul class="nav navbar-nav">
              <?php
              foreach (glob("./page/*") as $dir) {
                $dname=basename($dir);
                echo '<li class="dropdown">';
                echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$dname.'<span class="caret"></span></a>';
                echo '<ul class="dropdown-menu">';

                foreach (glob($dir."/*") as $f) {
                  $fname=basename($f,'.php');
                  echo '<li><a href="?page='.$f.'">'.$fname.'</a></li>';
                }
                echo '</ul>';
                echo '</li>';

              }

               ?>


            </ul>


          </div><!-- /.navbar-collapse -->
        </div><!-- /.container-fluid -->
      </nav>




      <div class="panel panel-default">
        <div class="panel-heading">PHP CODE</div>
        <div class="panel-body">
          <form id="from" action="#" method="post">
            <input type="hidden" name="act" value="run">
            <textarea name="code" style="width:100%;height:360px"><?=$code?></textarea>
          </form>

        </div>
        <div class="panel-footer clearfix">

          <button type="button" class="btn btn-success pull-right " onclick="run();">Run</button>
          <script>
          function run(){
            $("#from").submit();
          }

          </script>
        </div>
      </div>

      <div class="panel panel-default">
        <div class="panel-heading">Result</div>
        <div class="panel-body">
          <textarea style="width:100%;height:360px"><?php

          if ($act=="run"){
            eval($code);
          }

          ?></textarea>

        </div>
      </div>




    </div>
  </body>
</html>
