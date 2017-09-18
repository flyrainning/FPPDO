<!DOCTYPE html>
<html lang="zh-CN">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>EasyChart Example</title>

    <!-- jquery -->
    <script src="lib/jquery/jquery-1.11.3.min.js"></script>

    <!-- Bootstrap -->
    <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <script src="lib/bootstrap/js/bootstrap.min.js"></script>


    <!-- echarts -->
    <script src="../dist/Browser/js/echarts.min.js"></script>
    <script src="../dist/Browser/js/echarts-gl.min.js"></script>

    <!-- EasyChart -->
    <script src="../dist/Browser/js/EasyChart.min.js"></script>

    <script>
    //全局配置uri
      EasyChart_config={
        uri:"server/api/"
      };
    </script>

  </head>
  <body>
    <div class="container">

      <div class="page-header">
        <h1>Example <small>for EasyChart</small></h1>
      </div>


      <div class="panel panel-default">
        <div class="panel-heading">EasyChart Example</div>
        <div class="panel-body">

          <div
            EasyChart
            data-delay="10"
            data-debug="true"
            data-onload="init"
            data-api="chart.fruit"
            data-opt='{"echarts_style":"macarons","loading_text":"loading ...","height":"360px"}'
            data-post='{"title":"汇总"}'

          ></div>

          <script>
            function init(){
              console.log('chart loaded');
            }
          </script>


        </div>
      </div>




      <div class="panel panel-default">
        <div class="panel-heading">EasyChart 3D Example</div>
        <div class="panel-body">

          <div id="chart3d"></div>

          <script>
            var c3d=EC.add({
              id:"chart3d",
              api:"chart.fruit3D",
              height:"360px"
            });
            c3d.load({title:"Fruit 3D Example",subtitle:"3D 实例"});
          </script>


        </div>
      </div>


    </div>
  </body>
</html>
