<?php

require "../class/FPPDO.php";
require "../class/MSSQL.php";
require "../class/MySQL.php";
require "../class/SQLite.php";


$act=isset($_REQUEST['act'])?$_REQUEST['act']:"";
$code=isset($_REQUEST['code'])?$_REQUEST['code']:"";
$page=isset($_REQUEST['page'])?$_REQUEST['page']:"";

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


function FPPDOErrorHandler($errno, $errstr, $errfile, $errline){

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

set_error_handler("FPPDOErrorHandler");

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


    <script src="lib/codemirror/lib/codemirror.js"></script>
    <link rel="stylesheet" href="lib/codemirror/lib/codemirror.css">
    <script src="lib/codemirror/mode/xml/xml.js"></script>
    <script src="lib/codemirror/mode/javascript/javascript.js"></script>
    <script src="lib/codemirror/mode/css/css.js"></script>
    <script src="lib/codemirror/mode/htmlmixed/htmlmixed.js"></script>
    <script src="lib/codemirror/mode/clike/clike.js"></script>
    <script src="lib/codemirror/mode/php/php.js"></script>

    <link rel="stylesheet" href="lib/codemirror/theme/lesser-dark.css">
    <style>
    .CodeMirror {
      border: 1px solid #eee;
      height: 100%;
    }
    </style>


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
              function get_basename($filename){
        				return preg_replace('/^.+[\\\\\\/]/', '', $filename);
        			}
              foreach (glob("./page/*") as $dir) {
                $dname=get_basename($dir);
                echo '<li class="dropdown">';
                echo '<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">'.$dname.'<span class="caret"></span></a>';
                echo '<ul class="dropdown-menu">';

                foreach (glob($dir."/*") as $f) {
                  $fname=get_basename($f,'.php');
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
            <div style="width:100%;height:460px">
            <textarea id="code" name="code" height="auto" style="width:100%;height:auto;"><?=$code?></textarea>
            </div>
          </form>

        </div>
        <div class="panel-footer clearfix">

          <button type="button" class="btn btn-success pull-right " onclick="run();">Run</button>


          <script>
          function run(){
            $("#from").submit();
          }

          var myTextarea = document.getElementById('code');
          var CodeMirrorEditor = CodeMirror.fromTextArea(myTextarea, {
             mode: "text/x-php",
             styleActiveLine: true,
      			 lineNumbers: true,
      			 lineWrapping: true,
      			 theme:"lesser-dark"
          });

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
