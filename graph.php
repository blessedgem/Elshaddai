<!DOCTYPE html>
<html>
<head>
     <title>GemSoft</title>
     <link rel="stylesheet" href="css/bootstrap.css" type="text/css">

     <link rel="stylesheet" href="css/conditions.css" type="text/css">


   <meta charset='utf-8'>
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1">
   <link rel="stylesheet" href="css/bootstrap.css" type="text/css">
   <script src="http://code.jquery.com/jquery-latest.min.js" type="text/javascript"></script>
   <script src="js/bootstrap.js"></script>
   <script src="js/highcharts.js"></script>


</head>


<body>

<div class="container" style="width:100% !important;">


<h1><a href="#">GemSoft </a></h1>
   
<div class="navbar">
<div class="navbar-inner">
<div class="container">
<ul class="nav">
<li><a href="#">Home</a></li>


<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="icon-th-large"></i> Database
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
        <li><a href="form.html">Postgres</a></li>
        <li><a href="form.html">MySQL</a></li>
        <li><a href="sqform.html">Sqlite</a></li>
    </ul>
</li>


</li>
<li class="dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <i class="icon-th-large"></i> Hadoop
        <b class="caret"></b>
    </a>
    <ul class="dropdown-menu">
        <li><a href="form.html">Export</a></li>
        <li><a href="form.html">Import</a></li>
        
    </ul>
</li>
   
</ul>
</div>
   </div>
</div>


<div id="line_graph"  width="1000" height="400"></div>

<script>

  $.ajax({
    method: "GET",
      url: "/GraphAPI.php",
      success: function(values){
        //To convert string to json
      values = $.parseJSON(values);
      var mainData = new Array();
      var labels = [];

      for(var key in values){

        vals ={}

        if(values.hasOwnProperty(key)) {
          //Where you put the variables for the columns and 
          labels.push(values[key]['transaction_date']);
          mainData.push(parseFloat(values[key]['amount']));
        }

      }
      
      $(function (){

        $("#line_graph").highcharts({
          chart: {
            type: 'line'
          },
          xAxis: {
            categories: labels,
            show: true,
            labels: {
              enabled: true
            }
          },
          yAxis: {
 
          },
          series: [{
            animation:true,
            name: 'data',
            data: mainData,
            color: "#21a560"
          }]
        });
      });
      // data = {
      //   labels : labels,
      //   datasets: [
      //     { fillColor : "#21a560",data : mainData }
      //   ]
      // }
    },
    error: function(data){

    }
  });

</script>

</div>


</body>
</html>