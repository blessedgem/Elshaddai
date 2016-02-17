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
   <script src="js/Chart.js"></script>


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


<canvas id="line_graph"  width="1200" height="400"></canvas>

<script>
  $.ajax({
    method: "GET",
      url: "/GraphAPI.php",
      success: function(values){

      values = $.parseJSON(values);
      var mainData = [];
      var labels = [];

      for(var key in values){

        vals ={}

        if(values.hasOwnProperty(key)) {

          labels.push(values[key]['transaction_date']);
          mainData.push(values[key]['amount']);
        }

      }

      data = {
        labels : labels,
        datasets: [
          { fillColor : "#21a560",data : mainData }
        ]
      }
      
      console.log(data);

      var ctx = $("#line_graph").get(0).getContext("2d");
      // // This will get the first returned node in the jQuery collection.
      var myLineChart = new Chart(ctx).Line(data);

    },
    error: function(data){

    }
  });
</script>

</div>


</body>
</html>